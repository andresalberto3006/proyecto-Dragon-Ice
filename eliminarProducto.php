<?php
$servidor="";
$usuario="";
$contraseña="";
$baseDedatos="";

$conn = new mysqli($servidor, $usuario, $contraseña, $baseDedatos);

if ($conn->connect_error){
    die("Conexion fallida: ". $con->connect_error);
}

$codigpo = $_GET['codigo'];

$sql = "DELETE FROM producto WHERE codigo=$codigo";

