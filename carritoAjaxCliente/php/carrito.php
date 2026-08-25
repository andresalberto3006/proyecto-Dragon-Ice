<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['pedido'])) {
    echo json_encode(['ok' => false, 'mensaje' => 'No existe un pedido activo.']);
    exit;
}

$idPedido = (int)$_SESSION['pedido'];
$accion = $_POST['accion'] ?? '';

$s = $conn->prepare("SELECT estado FROM pedidos WHERE id=? LIMIT 1");
$s->bind_param('i', $idPedido);
$s->execute();
$pedido = $s->get_result()->fetch_assoc();

if (!$pedido || $pedido['estado'] !== 'Abierto') {
    unset($_SESSION['pedido']);
    echo json_encode(['ok' => false, 'mensaje' => 'El pedido ya no está disponible.']);
    exit;
}

if ($accion === 'agregar') {

    $codigo = (int)($_POST['codigo'] ?? 0);

    if ($codigo <= 0) {
        echo json_encode(['ok' => false, 'mensaje' => 'Producto no válido.']);
        exit;
    }

    $sp = $conn->prepare("SELECT * FROM productos WHERE id=? LIMIT 1");
    $sp->bind_param('i', $codigo);
    $sp->execute();
    $producto = $sp->get_result()->fetch_assoc();

    if (!$producto) {
        echo json_encode(['ok' => false, 'mensaje' => 'Producto no encontrado.']);
        exit;
    }

    $sc = $conn->prepare("SELECT * FROM carrito WHERE productos_id=? AND pedidos_id=?");
    $sc->bind_param('ii', $codigo, $idPedido);
    $sc->execute();
    $existente = $sc->get_result()->fetch_assoc();

    $nuevaCantidad = $existente ? $existente['cantidad'] + 1 : 1;

    if ($nuevaCantidad > $producto['stock']) {
        echo json_encode(['ok' => false, 'mensaje' => 'No existe stock suficiente.']);
        exit;
    }

    $total = $producto['precio'] * $nuevaCantidad;

    if ($existente) {
        $u = $conn->prepare("UPDATE carrito SET cantidad=?, costototal=? WHERE productos_id=? AND pedidos_id=?");
        $u->bind_param('idii', $nuevaCantidad, $total, $codigo, $idPedido);
        $u->execute();
    } else {
        $i = $conn->prepare("INSERT INTO carrito(productos_id, pedidos_id, cantidad, costototal) VALUES(?,?,?,?)");
        $i->bind_param('iiid', $codigo, $idPedido, $nuevaCantidad, $total);
        $i->execute();
    }

    echo json_encode(['ok' => true, 'mensaje' => 'Producto agregado al carrito.']);
    exit;

} elseif ($accion === 'mostrar') {

    $sm = $conn->prepare("
        SELECT c.productos_id, c.cantidad, c.costototal, p.nombre, p.precio, p.stock, p.imagen
        FROM carrito c
        INNER JOIN productos p ON c.productos_id = p.id
        WHERE c.pedidos_id = ?
    ");
    $sm->bind_param('i', $idPedido);
    $sm->execute();
    $resultado = $sm->get_result();

    $items = [];
    while ($fila = $resultado->fetch_assoc()) {
        $fila['imagen'] = !empty($fila['imagen']) ? "../" . $fila['imagen'] : "../imagenesproyecto/logo.png";
        $items[] = $fila;
    }

    echo json_encode($items);
    exit;

} elseif ($accion === 'vaciar') {

    $d = $conn->prepare("DELETE FROM carrito WHERE pedidos_id=?");
    $d->bind_param('i', $idPedido);

    echo json_encode($d->execute()
        ? ['ok' => true, 'mensaje' => 'Carrito vaciado.']
        : ['ok' => false, 'mensaje' => 'No se pudo vaciar el carrito.']);
    exit;

} else {

    echo json_encode(['ok' => false, 'mensaje' => 'Acción no válida.']);
    exit;
}