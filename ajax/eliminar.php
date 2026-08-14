<?php
session_start();
require 'db.php';
require 'funciones_carrito.php';
header('Content-Type: application/json');

$id_producto = $_POST['id_producto'] ?? null;

if ($id_producto && isset($_SESSION['carrito'][$id_producto])) {
    unset($_SESSION['carrito'][$id_producto]);
}

echo json_encode(construirRespuestaCarrito($pdo, $_SESSION['carrito'] ?? []));
