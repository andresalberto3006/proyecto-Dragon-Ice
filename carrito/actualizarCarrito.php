<?php

session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Vendedor') {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Sesión inválida."
    ]);
    exit();
}

include("../conexion.php");

$idPedido = isset($_POST['idPedido']) ? intval($_POST['idPedido']) : 0;
$idProducto = isset($_POST['idProducto']) ? intval($_POST['idProducto']) : 0;
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
$ci = $_SESSION['ci'];

if ($cantidad <= 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "La cantidad no es válida."
    ]);
    exit();
}

$stmtPedido = $conexion->prepare("
    SELECT * FROM pedidos
    WHERE id=? AND vendedor_ci=? AND estado='Pendiente'
");

$stmtPedido->bind_param("ii", $idPedido, $ci);
$stmtPedido->execute();

$resultadoPedido = $stmtPedido->get_result();

if ($resultadoPedido->num_rows == 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "El pedido no existe o ya no está pendiente."
    ]);
    exit();
}

$stmtProducto = $conexion->prepare("
    SELECT * FROM productos
    WHERE id=?
");

$stmtProducto->bind_param("i", $idProducto);
$stmtProducto->execute();

$resultadoProducto = $stmtProducto->get_result();

if ($resultadoProducto->num_rows == 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Producto no encontrado."
    ]);
    exit();
}

$producto = $resultadoProducto->fetch_assoc();

if ($cantidad > $producto['stock']) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe stock suficiente."
    ]);
    exit();
}

$total = $producto['precio'] * $cantidad;

$stmt = $conexion->prepare("
    UPDATE carrito
    SET cantidad=?, costototal=?
    WHERE productos_id=? AND pedidos_id=?
");

$stmt->bind_param(
    "idii",
    $cantidad,
    $total,
    $idProducto,
    $idPedido
);

if($stmt->execute()){

    echo json_encode([
        "ok" => true,
        "mensaje" => "Cantidad actualizada."
    ]);

}else{

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo actualizar el producto."
    ]);
}

exit();

?>