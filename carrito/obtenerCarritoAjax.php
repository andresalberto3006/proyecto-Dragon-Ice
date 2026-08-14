<?php

session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Vendedor') {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Sesión inválida."
    ]);
    exit();
}

include("../conexion.php");

$idPedido = isset($_GET['idPedido']) ? intval($_GET['idPedido']) : 0;
$ci = $_SESSION['ci'];

$stmtPedido = $conexion->prepare("
    SELECT * FROM pedidos
    WHERE id=? AND vendedor_ci=?
");

$stmtPedido->bind_param("ii", $idPedido, $ci);
$stmtPedido->execute();

$resultadoPedido = $stmtPedido->get_result();

if ($resultadoPedido->num_rows == 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Pedido no encontrado."
    ]);
    exit();
}

$stmt = $conexion->prepare("
    SELECT
        c.productos_id,
        c.cantidad,
        c.costototal,
        p.nombre,
        p.precio,
        p.stock
    FROM carrito c
    INNER JOIN productos p
        ON c.productos_id = p.id
    WHERE c.pedidos_id = ?
");

$stmt->bind_param("i", $idPedido);
$stmt->execute();

$resultado = $stmt->get_result();

$items = [];
$total = 0;

while ($fila = $resultado->fetch_assoc()) {

    $items[] = $fila;

    $total += $fila['costototal'];
}

echo json_encode([
    "ok" => true,
    "items" => $items,
    "total" => $total
]);

exit();

?>