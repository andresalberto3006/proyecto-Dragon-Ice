<?php
$conexion = new mysqli("localhost", "root", "", "dragonice");
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos");
}
$conexion->set_charset("utf8");
$conn = $conexion;
?>