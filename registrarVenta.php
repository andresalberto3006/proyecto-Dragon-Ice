<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: iniciosesion.php");
    exit();
}

if ($_SESSION['rol'] != 'Vendedor') {
    header("Location: paginaprincipal/02.admin.php");
    exit();
}

include("conexion.php");

$idPedido = $_POST['idPedido'];
$metodoPago = $_POST['metodo_pago'];
$ci = $_SESSION['ci'];
$nombreVendedor = $_SESSION['usuario'];

$sqlPedido = "SELECT * FROM pedidos
              WHERE id='$idPedido'
              AND vendedor_ci='$ci'
              AND estado='En proceso'";

$resultadoPedido = $conexion->query($sqlPedido);

if ($resultadoPedido->num_rows == 0) {
    header("Location: pedidos.php");
    exit();
}

$pedido = $resultadoPedido->fetch_assoc();

$ventaExistente = $conexion->query("SELECT * FROM ventas WHERE pedidos_id='$idPedido'");

if ($ventaExistente->num_rows > 0) {
    header("Location: ventas.php");
    exit();
}

$sqlProductos = "SELECT carrito.*, productos.nombre, productos.stock
                 FROM carrito
                 INNER JOIN productos
                 ON carrito.productos_id=productos.id
                 WHERE carrito.pedidos_id='$idPedido'";

$resultadoProductos = $conexion->query($sqlProductos);

if ($resultadoProductos->num_rows == 0) {
    echo "<script>
            alert('El pedido no tiene productos.');
            window.location='pedidos.php';
          </script>";
    exit();
}

$productosPedido = array();
$total = 0;
$stockCorrecto = true;
$productoSinStock = '';

while ($fila = $resultadoProductos->fetch_assoc()) {
    $productosPedido[] = $fila;
    $total = $total + $fila['costototal'];

    if ($fila['cantidad'] > $fila['stock']) {
        $stockCorrecto = false;
        $productoSinStock = $fila['nombre'];
    }
}

if (!$stockCorrecto) {
    echo "<script>
            alert('No existe stock suficiente para $productoSinStock.');
            window.location='pedidos.php';
          </script>";
    exit();
}

foreach ($productosPedido as $fila) {
    $cantidad = $fila['cantidad'];
    $codigoProducto = $fila['productos_id'];

    $sqlStock = "UPDATE productos
                 SET stock=stock-'$cantidad'
                 WHERE id='$codigoProducto'";

    $conexion->query($sqlStock);
}

$fecha = date('Y-m-d');
$cliente = $pedido['nombre'];

$sqlVenta = "INSERT INTO ventas
             (pedidos_id, fecha, cliente, vendedor_ci, nombrevendedor, total, metodo_pago)
             VALUES
             ('$idPedido', '$fecha', '$cliente', '$ci', '$nombreVendedor', '$total', '$metodoPago')";

if ($conexion->query($sqlVenta)) {
    $sqlPedido = "UPDATE pedidos
                  SET estado='Entregado', metodo_pago='$metodoPago'
                  WHERE id='$idPedido'";

    $conexion->query($sqlPedido);
}

header("Location: ventas.php");
exit();
?>