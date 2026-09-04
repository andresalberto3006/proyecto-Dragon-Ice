<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'conexion.php';

header('Content-Type: application/json; charset=utf-8');

$sql = "
    SELECT
        id,
        nombre,
        descripcion,
        precio,
        costo,
        stock,
        imagen
    FROM productos
    WHERE stock > 0
    ORDER BY id
";

$resultado = $conn->query($sql);

$productos = [];

while($fila = $resultado->fetch_assoc()) {
    if(!empty($fila['imagen'])) {
        $fila['imagen'] = "../" . $fila['imagen'];
    } else {
        $fila['imagen'] = "../imagenesproyecto/logo.png";
    }
    $productos[] = $fila;
}

$json = json_encode($productos);

if ($json === false) {
    echo "ERROR JSON: " . json_last_error_msg();
} else {
    echo $json;
}

$conn->close();
?>