<?php
include("connection.php");
$con = connection();

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['$precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

$sql = "INSERT INTO users (codigo, nombre, descripcion, precio, costo, stock) VALUES('$codigo','$nombre','$descripcion','$precio','$costo','$stock')";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: registroproducto.php");
}else{

}

?>