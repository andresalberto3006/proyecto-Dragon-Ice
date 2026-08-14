<?php

session_start();
require("conexion.php");

header("Content-Type: application/json");

if (!isset($_SESSION["pedido"])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe pedido activo"
    ]);
    exit;
}

$idPedido = $_SESSION["pedido"];

$accion = $_POST["accion"] ?? "";

switch ($accion) {

    case "agregar":

        $idProducto = $_POST["id"] ?? null;

        if (!$idProducto) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "Falta el id del producto"
            ]);
            exit;
        }

        // Buscar producto
        $stmtProducto = $conn->prepare("SELECT * FROM productos WHERE id = ?");
        $stmtProducto->bind_param("i", $idProducto);
        $stmtProducto->execute();
        $resultadoProducto = $stmtProducto->get_result();

        if ($resultadoProducto->num_rows == 0) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "Producto no encontrado"
            ]);
            exit;
        }

        $producto = $resultadoProducto->fetch_assoc();

        // Verificar si ya existe en el carrito
        $stmtExiste = $conn->prepare("SELECT * FROM carrito WHERE pedidos_id = ? AND productos_id = ?");
        $stmtExiste->bind_param("ii", $idPedido, $idProducto);
        $stmtExiste->execute();
        $resultadoExiste = $stmtExiste->get_result();

        $cantidadNueva = ($resultadoExiste->num_rows > 0)
            ? $resultadoExiste->fetch_assoc()["cantidad"] + 1
            : 1;

        if ($cantidadNueva > $producto["stock"]) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "No hay suficiente stock"
            ]);
            exit;
        }

        $subtotal = $cantidadNueva * $producto["precio"];

        if ($resultadoExiste->num_rows > 0) {

            $stmt = $conn->prepare("UPDATE carrito SET cantidad = ?, costototal = ? WHERE pedidos_id = ? AND productos_id = ?");
            $stmt->bind_param("idii", $cantidadNueva, $subtotal, $idPedido, $idProducto);

        } else {

            $stmt = $conn->prepare("INSERT INTO carrito (pedidos_id, productos_id, cantidad, costototal) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $idPedido, $idProducto, $cantidadNueva, $subtotal);

        }

        if ($stmt->execute()) {
            echo json_encode([
                "ok" => true,
                "mensaje" => "Producto agregado correctamente"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "mensaje" => $stmt->error
            ]);
        }

        break;

    case "mostrar":

        $stmt = $conn->prepare("
            SELECT
                c.productos_id,
                c.cantidad,
                c.costototal,
                p.nombre,
                p.precio,
                p.imagen
            FROM carrito c
            INNER JOIN productos p ON c.productos_id = p.id
            WHERE c.pedidos_id = ?
        ");
        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $carrito = [];

        while ($fila = $resultado->fetch_assoc()) {
            $carrito[] = $fila;
        }

        echo json_encode($carrito);

        break;

    case "vaciar":

        $stmt = $conn->prepare("DELETE FROM carrito WHERE pedidos_id = ?");
        $stmt->bind_param("i", $idPedido);

        if ($stmt->execute()) {
            echo json_encode([
                "ok" => true,
                "mensaje" => "Carrito vaciado correctamente"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "mensaje" => $stmt->error
            ]);
        }

        break;

    default:

        echo json_encode([
            "ok" => false,
            "mensaje" => "Acción no reconocida"
        ]);

}

$conn->close();
