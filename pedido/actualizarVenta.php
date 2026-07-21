<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: iniciosesion.php");
    exit();
}

if ($_SESSION['rol'] != 'Administrador') {
    header("Location: paginaprincipal/04.vendedor.php");
    exit();
}

include("conexion.php");

$id = $_POST['id'];
$cliente = $_POST['cliente'];
$fecha = $_POST['fecha'];
$metodoPago = $_POST['metodo_pago'];

$resultado = $conexion->query("SELECT pedidos_id FROM ventas WHERE id='$id'");

if ($resultado->num_rows > 0) {
    $venta = $resultado->fetch_assoc();
    $idPedido = $venta['pedidos_id'];

    $sqlVenta = "UPDATE ventas
                 SET cliente='$cliente',
                     fecha='$fecha',
                     metodo_pago='$metodoPago'
                 WHERE id='$id'";

    $conexion->query($sqlVenta);

    $sqlPedido = "UPDATE pedidos
                  SET nombre='$cliente', metodo_pago='$metodoPago'
                  WHERE id='$idPedido'";

    $conexion->query($sqlPedido);
}

header("Location: ventas.php");
exit();
?>