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

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$resultadoVenta = $conexion->query("SELECT pedidos_id FROM ventas WHERE id='$id'");

if ($resultadoVenta->num_rows > 0) {
    $venta = $resultadoVenta->fetch_assoc();
    $idPedido = $venta['pedidos_id'];

    $resultadoCarrito = $conexion->query("SELECT * FROM carrito WHERE pedidos_id='$idPedido'");

    while ($fila = $resultadoCarrito->fetch_assoc()) {
        $cantidad = $fila['cantidad'];
        $idProducto = $fila['productos_id'];

        $sqlStock = "UPDATE productos
                     SET stock=stock+'$cantidad'
                     WHERE id='$idProducto'";

        $conexion->query($sqlStock);
    }

    $conexion->query("DELETE FROM ventas WHERE id='$id'");

    $sqlPedido = "UPDATE pedidos
                  SET estado='En proceso', metodo_pago=''
                  WHERE id='$idPedido'";

    $conexion->query($sqlPedido);
}

header("Location: ventas.php");
exit();
?>
