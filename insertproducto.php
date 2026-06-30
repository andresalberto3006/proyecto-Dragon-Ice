<?php
include("connection.php");
$con = connection();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['$precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

$sql = "INSERT INTO users (id, nombre, descripcion, precio, costo, stock) VALUES('$id','$nombre','$descripcion','$precio','$costo','$stock')";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: registroproducto.php");
}else{

}

?>