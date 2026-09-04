<?php
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

$s = $conn->prepare('SELECT id,nombre AS Nombre,fecha AS Fecha,estado AS Estado,nombrevendedor AS NombreVendedor FROM pedidos WHERE id=? LIMIT 1');
$s->bind_param('i', $id);
$s->execute();
$p = $s->get_result()->fetch_assoc();

echo json_encode($p ? ['ok'=>true,'pedido'=>$p] : ['ok'=>false]);
?>