<?php

$nombreServidor = "localhost";
$usuario = "root";
$contraseña = "";
$basededatos = "QUINOVA";

$conexion = new mysqli($nombreServidor, $usuario, $contraseña, $basededatos);

if ($conexion->connect_error) {
    echo "Hubo un error :(";
}

$id = $_POST['id'];
$sql = "SELECT * FROM datos WHERE id=$id";

$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo $fila['id'] . " " . $fila['NombreCompleto'] . " " . $fila['Fechadenacimiento'] . " " . $fila['Curso'] . " " . $fila['Paralelo'] . " " . $fila['Codigorude'] . " " . $fila['Carnetdeidentidad'] . " " . $fila['telefono'] . " " . $fila['direccion'] . " " . $fila['rol'];
        $id = $fila['id'];
    }
}
