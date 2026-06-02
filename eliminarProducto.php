<?php
$servidor ="";
$usuario ="";
$contra ="";
$baseDedatos ="dragonice"

$conn = new mysql($servidor, $usuario, $contra, $baseDedatos);

if (conn->connect_error) {
    die("conexion fallida; " . $conn->connect_error);
}

$codigo = $_GET['codigo'];

$sql = "DELETE FROM productos WERE codigo=$codigo";

if ($conn->query($sql) === TRUE){
    echo "Producto eliminado exitosamente";
    header ("Location: readproducto.php");
} else{
    echo "Error " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>