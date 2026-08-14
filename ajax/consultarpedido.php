<?php

require("conexion.php");

header("Content-Type: application/json");

$id = $_POST["id"] ?? null;

if (!$id) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Falta el id del pedido"
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM pedidos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $pedido = $resultado->fetch_assoc();

    echo json_encode([
        "ok" => true,
        "pedido" => $pedido
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Pedido no encontrado"
    ]);

}

$stmt->close();
$conn->close();

?>