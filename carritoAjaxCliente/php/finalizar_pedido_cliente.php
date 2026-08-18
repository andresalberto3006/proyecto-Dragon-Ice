<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../conexion.php';

$idPedido = (int)($_SESSION['idPedidoCliente'] ?? 0);

if ($idPedido <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "No existe un pedido activo."]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$nombre = trim($input['nombre'] ?? '');
$metodo = trim($input['metodo_pago'] ?? '');

if (strlen($nombre) < 2 || $metodo === '') {
    echo json_encode(["ok" => false, "mensaje" => "Completa los datos del pedido."]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT COUNT(*) AS cantidad FROM carrito WHERE pedidos_id = ?"
);
$stmt->bind_param("i", $idPedido);
$stmt->execute();
$cantidad = (int)$stmt->get_result()->fetch_assoc()['cantidad'];

if ($cantidad <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "El carrito está vacío."]);
    exit;
}

$stmt = $conn->prepare(
    "UPDATE pedidos
     SET nombre = ?, estado = 'Pendiente', metodo_pago = ?
     WHERE id = ? AND estado = 'Abierto'"
);
$stmt->bind_param("ssi", $nombre, $metodo, $idPedido);

if (!$stmt->execute() || $stmt->affected_rows === 0) {
    echo json_encode(["ok" => false, "mensaje" => "No se pudo finalizar el pedido."]);
    exit;
}

echo json_encode([
    "ok" => true,
    "idPedido" => $idPedido
]);
