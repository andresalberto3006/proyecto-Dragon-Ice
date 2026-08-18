<?php

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


echo json_encode($productos);

$conn->close();

?>