<?php
 
include("conexion.php");
 
$sql = "SELECT id, nombre, descripcion, precio, imagen FROM productos WHERE stock > 0";
 
$resultado = $conn->query($sql);
 
$productos = [];
 
while($fila = $resultado->fetch_assoc()){
    $productos[] = $fila;
}
 
header("Content-Type: application/json");
echo json_encode($productos);
 
?>