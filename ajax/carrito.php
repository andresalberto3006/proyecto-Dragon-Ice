<?php

session_start();
require("conexion.php");

header("Content-Type: application/json");

if(!isset($_SESSION["pedido"])){
    echo json_encode([
        "ok"=>false,
        "mensaje"=>"No existe pedido activo"
    ]);
    exit;
}

$idPedido = $_SESSION["pedido"];

$accion = $_POST["accion"] ?? "";

switch($accion){

    case "agregar":

        $codigo = $_POST["codigo"];

        // Buscar producto
        $sqlProducto = "SELECT * FROM Productos WHERE codigo='$codigo'";
        $resultadoProducto = $conn->query($sqlProducto);
        if($resultadoProducto->num_rows == 0){

    echo json_encode([
        "ok"=>false,
        "mensaje"=>"Producto no encontrado"
    ]);

    exit;

}
        $producto = $resultadoProducto->fetch_assoc();

        // Verificar si ya existe
        $sqlExiste = "SELECT * FROM Carrito
                       WHERE Pedido_id='$idPedido'
                       AND Producto_codigo='$codigo'";

        $resultadoExiste = $conn->query($sqlExiste);

        if($resultadoExiste->num_rows > 0){

            $fila = $resultadoExiste->fetch_assoc();

            $cantidad = $fila["cantidad"] + 1;

            $subtotal = $cantidad * $producto["precio"];

            $sql = "UPDATE Carrito
                    SET cantidad='$cantidad',
                        costototal='$subtotal'
                    WHERE Pedido_id='$idPedido'
                    AND Producto_codigo='$codigo'";

        }else{

            $subtotal = $producto["precio"];

            $sql = "INSERT INTO Carrito
                    (Pedido_id,Producto_codigo,cantidad,costototal)
                    VALUES
                    ('$idPedido','$codigo',1,'$subtotal')";

        }

        if($conn->query($sql)){

    echo json_encode([
        "ok"=>true,
        "mensaje"=>"Producto agregado correctamente"
    ]);

}else{

    echo json_encode([
        "ok"=>false,
        "mensaje"=>$conn->error
    ]);

}

    break;
    case "mostrar":

    $sql = "SELECT
                c.Producto_codigo,
                c.cantidad,
                c.costototal,
                p.nombre,
                p.precio,
                p.imagen
            FROM Carrito c
            INNER JOIN Producto p
            ON c.Producto_codigo = p.codigo
            WHERE c.Pedido_id='$idPedido'";

    $resultado = $conn->query($sql);

    $carrito = [];

    while($fila = $resultado->fetch_assoc()){

        $carrito[] = $fila;

    }

    echo json_encode($carrito);

break;
case "vaciar":

    $sql = "DELETE FROM Carrito
            WHERE Pedido_id='$idPedido'";

    if($conn->query($sql)){

        echo json_encode([
            "ok"=>true,
            "mensaje"=>"Carrito vaciado correctamente"
        ]);

    }else{

        echo json_encode([
            "ok"=>false,
            "mensaje"=>$conn->error
        ]);

    }

break;

}
