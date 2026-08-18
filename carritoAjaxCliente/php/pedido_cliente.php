<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../conexion.php';

if ($conn->connect_error) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error de conexión con la base de datos."
    ]);
    exit;
}

$accion = $_GET['accion'] ?? '';


// ======================================================
// VERIFICAR SI YA EXISTE UN PEDIDO
// ======================================================

if ($accion === 'verificar') {

    if (!empty($_SESSION['idPedidoCliente'])) {

        $idPedido = (int) $_SESSION['idPedidoCliente'];

        $sql = "SELECT id, estado 
                FROM pedidos 
                WHERE id = ? 
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "Error al preparar la consulta: " . $conn->error
            ]);
            exit;
        }

        $stmt->bind_param("i", $idPedido);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $pedido = $resultado->fetch_assoc();

        if ($pedido && in_array(
            $pedido['estado'],
            ['Abierto', 'Pendiente', 'En proceso'],
            true
        )) {

            echo json_encode([
                "ok" => true,
                "tiene_pedido" => true,
                "idPedido" => (int) $pedido['id'],
                "estado" => $pedido['estado']
            ]);

            exit;
        }

        unset($_SESSION['idPedidoCliente']);
    }

    echo json_encode([
        "ok" => true,
        "tiene_pedido" => false
    ]);

    exit;
}


// ======================================================
// CREAR NUEVO PEDIDO
// ======================================================

if ($accion === 'crear') {

    // Si ya tiene uno activo, no creamos otro
    if (!empty($_SESSION['idPedidoCliente'])) {

        echo json_encode([
            "ok" => true,
            "idPedido" => (int) $_SESSION['idPedidoCliente'],
            "mensaje" => "Ya tienes un pedido activo."
        ]);

        exit;
    }


    $nombre = "Cliente";
    $fecha = date('Y-m-d');
    $estado = "Abierto";
    $metodoPago = "";


    /*
        El cliente todavía no tiene vendedor.

        Por eso:
        vendedor_ci = NULL
        nombrevendedor = NULL
    */

    $sql = "INSERT INTO pedidos
            (
                nombre,
                fecha,
                estado,
                vendedor_ci,
                nombrevendedor,
                metodo_pago
            )
            VALUES
            (
                ?,
                ?,
                ?,
                NULL,
                NULL,
                ?
            )";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        echo json_encode([
            "ok" => false,
            "mensaje" => "Error al preparar la creación del pedido: " . $conn->error
        ]);

        exit;
    }


    $stmt->bind_param(
        "ssss",
        $nombre,
        $fecha,
        $estado,
        $metodoPago
    );


    if (!$stmt->execute()) {

        echo json_encode([
            "ok" => false,
            "mensaje" => "Error al crear pedido: " . $stmt->error
        ]);

        exit;
    }


    // Obtener el ID generado automáticamente
    $idPedido = $conn->insert_id;


    // Guardarlo en la sesión del cliente
    $_SESSION['idPedidoCliente'] = $idPedido;


    echo json_encode([
        "ok" => true,
        "idPedido" => $idPedido,
        "mensaje" => "Pedido creado correctamente."
    ]);

    exit;
}


// ======================================================
// ACCIÓN NO VÁLIDA
// ======================================================

echo json_encode([
    "ok" => false,
    "mensaje" => "Acción no válida."
]);