<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../conexion.php';

if ($conn->connect_error) {
    echo json_encode(["ok" => false, "mensaje" => "Error de conexión."]);
    exit;
}

$idPedido = (int)($_SESSION['idPedidoCliente'] ?? 0);

if ($idPedido <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "Primero debes crear un pedido."]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$accion = $input['accion'] ?? $_GET['accion'] ?? '';

if ($accion === 'listar') {
    $stmt = $conn->prepare(
        "SELECT c.productos_id, p.nombre, p.precio, c.cantidad,
                (p.precio * c.cantidad) AS subtotal
         FROM carrito c
         INNER JOIN productos p ON p.id = c.productos_id
         WHERE c.pedidos_id = ?
         ORDER BY p.nombre"
    );
    $stmt->bind_param("i", $idPedido);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $productos = [];
    $total = 0;

    while ($fila = $resultado->fetch_assoc()) {
        $fila['precio'] = number_format((float)$fila['precio'], 2, '.', '');
        $fila['subtotal'] = number_format((float)$fila['subtotal'], 2, '.', '');
        $fila['cantidad'] = (int)$fila['cantidad'];
        $total += (float)$fila['subtotal'];
        $productos[] = $fila;
    }

    echo json_encode([
        "ok" => true,
        "productos" => $productos,
        "total" => number_format($total, 2, '.', '')
    ]);
    exit;
}

if ($accion === 'agregar') {
    $idProducto = (int)($input['idProducto'] ?? 0);
    $cantidad = (int)($input['cantidad'] ?? 0);

    if ($idProducto <= 0 || $cantidad <= 0) {
        echo json_encode(["ok" => false, "mensaje" => "Datos inválidos."]);
        exit;
    }

    $stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $producto = $stmt->get_result()->fetch_assoc();

    if (!$producto) {
        echo json_encode(["ok" => false, "mensaje" => "Producto no encontrado."]);
        exit;
    }

    $stock = (int)$producto['stock'];

    $stmt = $conn->prepare(
        "SELECT cantidad FROM carrito WHERE productos_id = ? AND pedidos_id = ? LIMIT 1"
    );
    $stmt->bind_param("ii", $idProducto, $idPedido);
    $stmt->execute();
    $existente = $stmt->get_result()->fetch_assoc();

    $nuevaCantidad = $cantidad + (int)($existente['cantidad'] ?? 0);

    if ($nuevaCantidad > $stock) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "No hay suficiente stock. Disponible: $stock"
        ]);
        exit;
    }

    if ($existente) {
        $stmt = $conn->prepare(
            "UPDATE carrito SET cantidad = ? WHERE productos_id = ? AND pedidos_id = ?"
        );
        $stmt->bind_param("iii", $nuevaCantidad, $idProducto, $idPedido);
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO carrito (productos_id, pedidos_id, cantidad, costototal)
             SELECT id, ?, ?, precio * ?
             FROM productos
             WHERE id = ?"
        );
        $stmt->bind_param("iiiii", $idPedido, $cantidad, $cantidad, $idProducto);
    }

    if (!$stmt->execute()) {
        echo json_encode(["ok" => false, "mensaje" => "No se pudo agregar el producto."]);
        exit;
    }

    // Recalcular costototal de la línea.
    $stmt = $conn->prepare(
        "UPDATE carrito c
         INNER JOIN productos p ON p.id = c.productos_id
         SET c.costototal = p.precio * c.cantidad
         WHERE c.productos_id = ? AND c.pedidos_id = ?"
    );
    $stmt->bind_param("ii", $idProducto, $idPedido);
    $stmt->execute();

    echo json_encode(["ok" => true]);
    exit;
}

if ($accion === 'actualizar') {
    $idProducto = (int)($input['idProducto'] ?? 0);
    $cantidad = (int)($input['cantidad'] ?? 0);

    if ($cantidad <= 0) {
        $stmt = $conn->prepare(
            "DELETE FROM carrito WHERE productos_id = ? AND pedidos_id = ?"
        );
        $stmt->bind_param("ii", $idProducto, $idPedido);
        $stmt->execute();
        echo json_encode(["ok" => true]);
        exit;
    }

    $stmt = $conn->prepare("SELECT stock, precio FROM productos WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $producto = $stmt->get_result()->fetch_assoc();

    if (!$producto) {
        echo json_encode(["ok" => false, "mensaje" => "Producto no encontrado."]);
        exit;
    }

    if ($cantidad > (int)$producto['stock']) {
        echo json_encode(["ok" => false, "mensaje" => "Cantidad superior al stock disponible."]);
        exit;
    }

    $costototal = (float)$producto['precio'] * $cantidad;

    $stmt = $conn->prepare(
        "UPDATE carrito
         SET cantidad = ?, costototal = ?
         WHERE productos_id = ? AND pedidos_id = ?"
    );
    $stmt->bind_param("idii", $cantidad, $costototal, $idProducto, $idPedido);
    $stmt->execute();

    echo json_encode(["ok" => true]);
    exit;
}

if ($accion === 'eliminar') {
    $idProducto = (int)($input['idProducto'] ?? 0);

    $stmt = $conn->prepare(
        "DELETE FROM carrito WHERE productos_id = ? AND pedidos_id = ?"
    );
    $stmt->bind_param("ii", $idProducto, $idPedido);
    $stmt->execute();

    echo json_encode(["ok" => true]);
    exit;
}

echo json_encode(["ok" => false, "mensaje" => "Acción no válida."]);
