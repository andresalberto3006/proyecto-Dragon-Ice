<?php

session_start();

require 'conexion.php';

header('Content-Type: application/json; charset=utf-8');


/* VERIFICAR PEDIDO ACTIVO */

if(!isset($_SESSION['pedido'])) {

    echo json_encode([
        'ok' => false,
        'mensaje' => 'No existe pedido activo'
    ]);

    exit;
}


$idPedido = (int)$_SESSION['pedido'];

$accion = $_POST['accion'] ?? '';


/* ACCIONES DEL CARRITO */

switch($accion) {


    /* =========================================
       AGREGAR PRODUCTO
    ========================================= */

    case 'agregar':

        $codigo = (int)($_POST['codigo'] ?? 0);


        /* BUSCAR PRODUCTO */

        $s = $conn->prepare("
            SELECT
                id,
                nombre,
                precio,
                stock,
                imagen
            FROM productos
            WHERE id = ?
            LIMIT 1
        ");

        $s->bind_param(
            'i',
            $codigo
        );

        $s->execute();

        $resultado = $s->get_result();


        /* PRODUCTO NO ENCONTRADO */

        if(!$resultado->num_rows) {

            echo json_encode([
                'ok' => false,
                'mensaje' => 'Producto no encontrado'
            ]);

            exit;
        }


        $producto = $resultado->fetch_assoc();


        /* VERIFICAR STOCK */

        if((int)$producto['stock'] <= 0) {

            echo json_encode([
                'ok' => false,
                'mensaje' => 'Producto sin stock'
            ]);

            exit;
        }


        /* BUSCAR SI YA EXISTE EN EL CARRITO */

        $s = $conn->prepare("
            SELECT cantidad
            FROM carrito
            WHERE pedidos_id = ?
            AND productos_id = ?
            LIMIT 1
        ");

        $s->bind_param(
            'ii',
            $idPedido,
            $codigo
        );

        $s->execute();

        $resultado = $s->get_result();


        /* =========================================
           SI EL PRODUCTO YA EXISTE
        ========================================= */

        if($resultado->num_rows) {

            $fila = $resultado->fetch_assoc();

            $cantidad =
                (int)$fila['cantidad'] + 1;


            /* VERIFICAR STOCK */

            if($cantidad > (int)$producto['stock']) {

                echo json_encode([
                    'ok' => false,
                    'mensaje' => 'No hay suficiente stock disponible'
                ]);

                exit;
            }


            /* CALCULAR SUBTOTAL */

            $subtotal =
                $cantidad * (float)$producto['precio'];


            /* ACTUALIZAR CARRITO */

            $s = $conn->prepare("
                UPDATE carrito
                SET
                    cantidad = ?,
                    costototal = ?
                WHERE pedidos_id = ?
                AND productos_id = ?
            ");

            $s->bind_param(
                'idii',
                $cantidad,
                $subtotal,
                $idPedido,
                $codigo
            );

        }


        /* =========================================
           SI EL PRODUCTO NO EXISTE
        ========================================= */

        else {

            $cantidad = 1;

            $subtotal =
                (float)$producto['precio'];


            /* INSERTAR PRODUCTO */

            $s = $conn->prepare("
                INSERT INTO carrito
                (
                    productos_id,
                    pedidos_id,
                    cantidad,
                    costototal
                )
                VALUES
                (?, ?, ?, ?)
            ");

            $s->bind_param(
                'iiid',
                $codigo,
                $idPedido,
                $cantidad,
                $subtotal
            );

        }


        /* RESPUESTA */

        if($s->execute()) {

            echo json_encode([
                'ok' => true,
                'mensaje' => 'Producto agregado correctamente'
            ]);

        } else {

            echo json_encode([
                'ok' => false,
                'mensaje' => $s->error
            ]);

        }

        break;



    /* =========================================
       MOSTRAR CARRITO
    ========================================= */

    case 'mostrar':

    $s = $conn->prepare("
        SELECT
            c.productos_id AS Producto_id,
            c.cantidad,
            c.costototal,
            p.nombre,
            p.precio,
            p.imagen
        FROM carrito c
        INNER JOIN productos p
            ON c.productos_id = p.id
        WHERE c.pedidos_id = ?
    ");

    $s->bind_param(
        'i',
        $idPedido
    );

    $s->execute();

    $resultado = $s->get_result();

    $productos = [];


    while($fila = $resultado->fetch_assoc()) {

        if(!empty($fila['imagen'])) {

            $fila['imagen'] = "../" . $fila['imagen'];

        } else {

            $fila['imagen'] = "../imagenesproyecto/logo.png";

        }

        $productos[] = $fila;
    }


    echo json_encode($productos);

    break;



    /* =========================================
       VACIAR CARRITO
    ========================================= */

    case 'vaciar':


        $s = $conn->prepare("
            DELETE FROM carrito
            WHERE pedidos_id = ?
        ");


        $s->bind_param(
            'i',
            $idPedido
        );


        if($s->execute()) {

            echo json_encode([
                'ok' => true,
                'mensaje' => 'Carrito vaciado correctamente'
            ]);

        } else {

            echo json_encode([
                'ok' => false,
                'mensaje' => $s->error
            ]);

        }

        break;



    /* =========================================
       ACCIÓN NO VÁLIDA
    ========================================= */

    default:

        echo json_encode([
            'ok' => false,
            'mensaje' => 'Acción no válida'
        ]);

        break;

}


/* CERRAR CONEXIÓN */

$conn->close();

?>
