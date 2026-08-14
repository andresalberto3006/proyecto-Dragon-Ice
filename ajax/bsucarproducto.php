La tabla es productos (minúscula), y el SQL está concatenado directo con $_GET["nombre"] — vulnerable a inyección SQL. También usa = exacto, que para una búsqueda de productos normalmente conviene que sea parcial (LIKE), ya que si el usuario escribe "helado" no encontraría "Helado Snoopy" con una igualdad exacta.

php
<?php

include "conexion.php";

header("Content-Type: application/json");

$nombre = $_GET["nombre"] ?? "";

$stmt = $conn->prepare("SELECT * FROM productos WHERE nombre LIKE ?");
$busqueda = "%" . $nombre . "%";
$stmt->bind_param("s", $busqueda);
$stmt->execute();

$resultado = $stmt->get_result();

$productos = [];

while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

echo json_encode($productos);

$stmt->close();
$conn->close();

?>