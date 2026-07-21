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

$idProducto = $_POST['idProducto'];
$idPedido = $_POST['idPedido'];
$cantidad = $_POST['cantidad'];
$ci = $_SESSION['ci'];

$sqlPedido = "SELECT * FROM pedidos
              WHERE id='$idPedido'
              AND vendedor_ci='$ci'
              AND estado='Pendiente'";

$resultadoPedido = $conexion->query($sqlPedido);

if ($resultadoPedido->num_rows == 0) {
    header("Location: pedidos.php");
    exit();
}

$sqlProducto = "SELECT * FROM productos WHERE id='$idProducto'";
$resultadoProducto = $conexion->query($sqlProducto);

if ($resultadoProducto->num_rows == 0) {
    header("Location: miCarrito.php?idPedido=$idPedido");
    exit();
}

$producto = $resultadoProducto->fetch_assoc();

$sqlCarrito = "SELECT * FROM carrito
               WHERE productos_id='$idProducto'
               AND pedidos_id='$idPedido'";

$resultadoCarrito = $conexion->query($sqlCarrito);
$nuevaCantidad = $cantidad;

if ($resultadoCarrito->num_rows > 0) {
    $productoCarrito = $resultadoCarrito->fetch_assoc();
    $nuevaCantidad = $productoCarrito['cantidad'] + $cantidad;
}

if ($nuevaCantidad > $producto['stock']) {
    echo "<script>
            alert('No existe stock suficiente.');
            window.location='miCarrito.php?idPedido=$idPedido';
          </script>";
    exit();
}

$total = $producto['precio'] * $nuevaCantidad;

if ($resultadoCarrito->num_rows > 0) {
    $sql = "UPDATE carrito
            SET cantidad='$nuevaCantidad', costototal='$total'
            WHERE productos_id='$idProducto'
            AND pedidos_id='$idPedido'";
} else {
    $total = $producto['precio'] * $cantidad;

    $sql = "INSERT INTO carrito
            (productos_id, pedidos_id, cantidad, costototal)
            VALUES
            ('$idProducto', '$idPedido', '$cantidad', '$total')";
}

$conexion->query($sql);

header("Location: miCarrito.php?idPedido=$idPedido");
exit();
?>
