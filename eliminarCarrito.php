<?php
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Vendedor') {
    echo json_encode(["ok" => false, "mensaje" => "Sesión inválida."]);
    exit();
}

include("conexion.php");

$idPedido = isset($_POST['idPedido']) ? intval($_POST['idPedido']) : 0;
$idProducto = isset($_POST['idProducto']) ? intval($_POST['idProducto']) : 0;
$ci = $_SESSION['ci'];

$stmtPedido = $conexion->prepare("SELECT * FROM pedidos WHERE id=? AND vendedor_ci=? AND estado='Pendiente'");
$stmtPedido->bind_param("ii", $idPedido, $ci);
$stmtPedido->execute();
$resultadoPedido = $stmtPedido->get_result();

if ($resultadoPedido->num_rows == 0) {
    echo json_encode(["ok" => false, "mensaje" => "El pedido no existe o ya no está pendiente."]);
    exit();
}

$stmt = $conexion->prepare("DELETE FROM carrito WHERE pedidos_id=? AND productos_id=?");
$stmt->bind_param("ii", $idPedido, $idProducto);
$stmt->execute();

echo json_encode(["ok" => true, "mensaje" => "Producto eliminado del carrito."]);
exit();
?>