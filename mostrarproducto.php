<?php

$nombreServidor = "localhost";
$usuario = "root";
$contraseña = "";
$basededatos = "dragonice";

$conexion = new mysqli($nombreServidor, $usuario, $contraseña, $basededatos);

if ($conexion->connect_error) {
    echo "Hubo un error :(";
}

$id = $_POST['id'];
$sql = "SELECT * FROM datos WHERE id=$id";

$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo $fila['Codigo'] . " " . $fila['Nombre'] . " " . $fila['Descripcion'] . " " . $fila['Precio'] . " " . $fila['Costo'] . " " . $fila['Stock'] ;
    }
}
?>