<?php

session_start();

require("conexion.php");

header("Content-Type: application/json");

$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibieron datos"
    ]);
    exit;
}

$nombre = $datos["nombre"];
$telefono = $datos["telefono"];
$direccion = $datos["direccion"];
$metodo = $datos["metodo"];

// Vendedor genérico asignado por defecto (ajustar si hay otra lógica de asignación)
$vendedor_ci = 20000000;
$nombrevendedor = "Vendedor";

$stmt = $conn->prepare("
    INSERT INTO pedidos(nombre, telefono, direccion, fecha, estado, vendedor_ci, nombrevendedor, metodo_pago)
    VALUES (?, ?, ?, NOW(), 'Pendiente', ?, ?, ?)
");

$stmt->bind_param(
    "sssiss",
    $nombre,
    $telefono,
    $direccion,
    $vendedor_ci,
    $nombrevendedor,
    $metodo
);

if ($stmt->execute()) {

    $idPedido = $conn->insert_id;
    $_SESSION["pedido"] = $idPedido;

    echo json_encode([
        "ok" => true,
        "pedido" => $idPedido,
        "sesion" => $_SESSION["pedido"]
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => $stmt->error,
        "mysql" => $conn->error
    ]);

}

$stmt->close();
$conn->close();