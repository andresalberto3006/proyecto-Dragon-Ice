<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

include("conexion.php");

$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$sql = "INSERT INTO usuario
(nombre,direccion,celular,rol,estado)
VALUES
('$nombre','$direccion','$celular','$rol','$estado')";

mysqli_query($conexion,$sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuario Registrado</title>

<style>

body{
    font-family: Arial, sans-serif;
    background-image:url("music-musical-instrument-guitar-two-dark-background.png");
    background-size:cover;
    background-position:center;
    display:flex;
    justify-content:center;
    align-items:center;
    height:150vh;
}

.caja{
    width:350px;
    background:rgba(24,45,75,.9);
    padding:30px;
    border-radius:15px;
    border:2px solid #6bb7ff;
    text-align:center;
}

h2{
    color:#fff3d6;
    margin-bottom:15px;
}

p{
    color:white;
}

.boton{
    display:block;
    text-decoration:none;
    background:#4da6ff;
    color:white;
    padding:12px;
    margin-top:15px;
    border-radius:10px;
}

.boton:hover{
    background:#ffae42;
}

</style>
</head>

<body>

<div class="caja">

<h2>Usuario registrado correctamente</h2>

<p>El usuario fue guardado exitosamente.</p>

<a href="08.formulariousuario.html" class="boton">
Inicio
</a>

<a href="readusuario.php" class="boton">
Ver lista de usuarios
</a>

</div>

</body>
</html>