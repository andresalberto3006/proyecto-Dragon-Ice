<?php

session_start();

header("Content-Type: application/json");

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Vendedor'){
    echo json_encode([
        "ok" => false,
        "mensaje" => "Sesión inválida."
    ]);
    exit();
}

include("conexion.php");

$idProducto = isset($_POST['idProducto']) ? intval($_POST['idProducto']) : 0;
$idPedido = isset($_POST['idPedido']) ? intval($_POST['idPedido']) : 0;
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
$ci = $_SESSION['ci'];

if($cantidad <= 0){
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

if($resultadoPedido->num_rows == 0){
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

if($resultadoProducto->num_rows == 0){
    echo json_encode([
        "ok" => false,
        "mensaje" => "Producto no encontrado."
    ]);
    exit();
}

$producto = $resultadoProducto->fetch_assoc();



if($cantidad > $producto['stock']){
    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe stock suficiente."
    ]);
    exit();
}



$stmtCarrito = $conexion->prepare("
    SELECT * FROM carrito
    WHERE productos_id=? AND pedidos_id=?
");

$stmtCarrito->bind_param("ii", $idProducto, $idPedido);
$stmtCarrito->execute();

$resultadoCarrito = $stmtCarrito->get_result();

$nuevaCantidad = $cantidad;



if($resultadoCarrito->num_rows > 0){

    $productoCarrito = $resultadoCarrito->fetch_assoc();

    $nuevaCantidad = $productoCarrito['cantidad'] + $cantidad;

}



if($nuevaCantidad > $producto['stock']){

    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe stock suficiente para esa cantidad."
    ]);

    exit();
}



if($resultadoCarrito->num_rows > 0){

    $total = $producto['precio'] * $nuevaCantidad;

    $stmt = $conexion->prepare("
        UPDATE carrito
        SET cantidad=?, costototal=?
        WHERE productos_id=? AND pedidos_id=?
    ");

    $stmt->bind_param(
        "idii",
        $nuevaCantidad,
        $total,
        $idProducto,
        $idPedido
    );

    $stmt->execute();

}else{

    $total = $producto['precio'] * $cantidad;

    $stmt = $conexion->prepare("
        INSERT INTO carrito
        (productos_id,pedidos_id,cantidad,costototal)
        VALUES (?,?,?,?)
    ");

    $stmt->bind_param(
        "iiid",
        $idProducto,
        $idPedido,
        $cantidad,
        $total
    );

    $stmt->execute();

}



echo json_encode([
    "ok" => true,
    "mensaje" => "Producto agregado al carrito."
]);

exit();

?>