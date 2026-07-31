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
$idProducto = $_POST['idProducto'];
$cantidad = $_POST['cantidad'];
$ci = $_SESSION['ci'];

$sqlPedido = "SELECT * FROM pedidos
              WHERE id='$idPedido'
              AND vendedor_ci='$ci'
              AND estado='Pendiente'";

$resultadoPedido = $conexion->query($sqlPedido);
$resultadoProducto = $conexion->query("SELECT * FROM productos WHERE id='$idProducto'");

if ($resultadoPedido->num_rows > 0 && $resultadoProducto->num_rows > 0) {
    $producto = $resultadoProducto->fetch_assoc();

    if ($cantidad > 0 && $cantidad <= $producto['stock']) {
        $total = $producto['precio'] * $cantidad;

        $sql = "UPDATE carrito
                SET cantidad='$cantidad', costototal='$total'
                WHERE productos_id='$idProducto'
                AND pedidos_id='$idPedido'";

        $conexion->query($sql);
    }
}

header("Location: miCarrito.php?idPedido=$idPedido");
exit();
?>