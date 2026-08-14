<?php

session_start();

header("Content-Type: application/json");


$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["pedidoActivo" => false, "mensaje" => "Error de conexión"]);
    exit;
}


if (isset($_SESSION["pedido"])) {

    $stmt = $pdo->prepare("SELECT id, nombre, fecha, estado, vendedor_ci, nombrevendedor, metodo_pago 
                            FROM pedidos WHERE id = ?");
    $stmt->execute([$_SESSION["pedido"]]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pedido) {
        echo json_encode([
            "pedidoActivo" => true,
            "pedido" => $pedido
        ]);
    } else {

        unset($_SESSION["pedido"]);
        echo json_encode([
            "pedidoActivo" => false
        ]);
    }

} else {

    echo json_encode([
        "pedidoActivo" => false
    ]);

}

?>