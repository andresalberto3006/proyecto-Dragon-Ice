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

$idPedido = isset($_GET['idPedido']) ? $_GET['idPedido'] : 0;
$idProducto = isset($_GET['idProducto']) ? $_GET['idProducto'] : 0;
$ci = $_SESSION['ci'];

$sqlPedido = "SELECT * FROM pedidos
              WHERE id='$idPedido'
              AND vendedor_ci='$ci'
              AND estado='Pendiente'";

$resultadoPedido = $conexion->query($sqlPedido);

if ($resultadoPedido->num_rows > 0) {
    $sql = "DELETE FROM carrito
            WHERE pedidos_id='$idPedido'
            AND productos_id='$idProducto'";

    $conexion->query($sql);
}

header("Location: miCarrito.php?idPedido=$idPedido");
exit();
?>