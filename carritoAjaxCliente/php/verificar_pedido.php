<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$activo = false;

if (isset($_SESSION['pedido'])) {

    $id = (int)$_SESSION['pedido'];

    $s = $conn->prepare('SELECT estado FROM pedidos WHERE id=? LIMIT 1');
    $s->bind_param('i', $id);
    $s->execute();
    $p = $s->get_result()->fetch_assoc();

    if ($p && $p['estado'] === 'Abierto') {
        $activo = true;
    } else {
        unset($_SESSION['pedido']);
    }
}

echo json_encode(['pedidoActivo' => $activo]);
?>