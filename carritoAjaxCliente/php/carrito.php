
<?php
session_start();
require 'conexion.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['pedido'])) {
    echo json_encode([
        'ok' => false,
        'mensaje' => 'No existe un pedido activo.'
    ]);
    exit;
}

$idPedido = (int) $_SESSION['pedido'];
$accion = isset($_POST['accion']) ? $_POST['accion'] : '';

$s = $conn->prepare("SELECT estado FROM pedidos WHERE id = ? LIMIT 1");
$s->bind_param('i', $idPedido);
$s->execute();
$pedido = $s->get_result()->fetch_assoc();
$s->close();

if (!$pedido || $pedido['estado'] !== 'Abierto') {
    unset($_SESSION['pedido']);

    echo json_encode([
        'ok' => false,
        'mensaje' => 'El pedido ya no está disponible.'
    ]);
    exit;
}
if ($accion === 'agregar') {

    $codigo = isset($_POST['codigo']) ? (int) $_POST['codigo'] : 0;
    $cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 1;

    if ($codigo <= 0 || $cantidad <= 0) {
        echo json_encode([
            'ok' => false,
            'mensaje' => 'El producto o la cantidad no son válidos.'
        ]);
        exit;
    }
    $sp = $conn->prepare(
        "SELECT id, nombre, precio, stock
         FROM productos
         WHERE id = ?
         LIMIT 1"
    );
    $sp->bind_param('i', $codigo);
    $sp->execute();
    $producto = $sp->get_result()->fetch_assoc();
    $sp->close();

    if (!$producto) {
        echo json_encode([
            'ok' => false,
            'mensaje' => 'Producto no encontrado.'
        ]);
        exit;
    }

    if ((int) $producto['stock'] <= 0) {
        echo json_encode([
            'ok' => false,
            'mensaje' => 'Este producto no tiene stock disponible.'
        ]);
        exit;
    }
    
    $sc = $conn->prepare(
        "SELECT cantidad
         FROM carrito
         WHERE productos_id = ? AND pedidos_id = ?
         LIMIT 1"
    );
    $sc->bind_param('ii', $codigo, $idPedido);
    $sc->execute();
    $existente = $sc->get_result()->fetch_assoc();
    $sc->close();

    $cantidadActual = $existente ? (int) $existente['cantidad'] : 0;
    $nuevaCantidad = $cantidadActual + $cantidad;

    if ($nuevaCantidad > (int) $producto['stock']) {
        $disponible = (int) $producto['stock'] - $cantidadActual;

        echo json_encode([
            'ok' => false,
            'mensaje' => $disponible > 0
                ? "Solo puedes agregar {$disponible} unidad(es) más de este producto."
                : 'Ya alcanzaste el stock disponible de este producto.'
        ]);
        exit;
    }

    $total = (float) $producto['precio'] * $nuevaCantidad;

    if ($existente) {
        $u = $conn->prepare(
            "UPDATE carrito
             SET cantidad = ?, costototal = ?
             WHERE productos_id = ? AND pedidos_id = ?"
        );
        $u->bind_param('idii', $nuevaCantidad, $total, $codigo, $idPedido);
        $correcto = $u->execute();
        $u->close();

    } else {
        $i = $conn->prepare(
            "INSERT INTO carrito
             (productos_id, pedidos_id, cantidad, costototal)
             VALUES (?, ?, ?, ?)"
        );
        $i->bind_param('iiid', $codigo, $idPedido, $nuevaCantidad, $total);
        $correcto = $i->execute();
        $i->close();
    }

    echo json_encode(
        $correcto
            ? [
                'ok' => true,
                'mensaje' => 'Producto agregado al carrito.'
            ]
            : [
                'ok' => false,
                'mensaje' => 'No se pudo agregar el producto.'
            ]
    );
    exit;
}

elseif ($accion === 'mostrar') {

    $sm = $conn->prepare(
        "SELECT
            c.productos_id,
            c.cantidad,
            c.costototal,
            p.nombre,
            p.precio,
            p.stock,
            p.imagen
         FROM carrito c
         INNER JOIN productos p ON c.productos_id = p.id
         WHERE c.pedidos_id = ?"
    );

    $sm->bind_param('i', $idPedido);
    $sm->execute();
    $resultado = $sm->get_result();

    $items = [];

    while ($fila = $resultado->fetch_assoc()) {

        $fila['imagen'] = !empty($fila['imagen'])
            ? '../' . $fila['imagen']
            : '../imagenesproyecto/logo.png';

        $items[] = $fila;
    }

    $sm->close();

    echo json_encode($items);
    exit;
}

elseif ($accion === 'vaciar') {

    $d = $conn->prepare(
        "DELETE FROM carrito WHERE pedidos_id = ?"
    );
    $d->bind_param('i', $idPedido);

    $correcto = $d->execute();
    $d->close();

    echo json_encode(
        $correcto
            ? [
                'ok' => true,
                'mensaje' => 'Carrito vaciado.'
            ]
            : [
                'ok' => false,
                'mensaje' => 'No se pudo vaciar el carrito.'
            ]
    );
    exit;
}
else {

    echo json_encode([
        'ok' => false,
        'mensaje' => 'Acción no válida.'
    ]);
    exit;
}
?>
