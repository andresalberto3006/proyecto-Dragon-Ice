<?php

$conexion = mysqli_connect("localhost","root","","dragonice");

if(!$conexion){
    die("Error de conexión");
}

$idProducto = $_GET["idProducto"];
$idPedido = $_GET["idPedido"];

$sql = "DELETE FROM carrito
        WHERE productos_id='$idProducto'
        AND pedidos_id='$idPedido'";

if(mysqli_query($conexion,$sql)){

    header("Location: miCarrito.php?idPedido=".$idPedido);

}else{

    echo "Error al eliminar: ".mysqli_error($conexion);

}

?>