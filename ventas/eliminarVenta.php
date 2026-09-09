<?php
session_start();

if(!isset($_SESSION['rol'])){
    header("Location: ../iniciosesion.php");
    exit();
}

if($_SESSION['rol'] !== 'Administrador'){
    header("Location: ../paginaprincipal/vendedor20.php");
    exit();
}

include("../conexion.php");

$id = (int)($_GET['id'] ?? 0);

if($id <= 0){
    header("Location: ventas.php");
    exit();
}

$s = $conexion->prepare("SELECT pedidos_id FROM ventas WHERE id=? LIMIT 1");
$s->bind_param('i', $id);
$s->execute();
$venta = $s->get_result()->fetch_assoc();

if($venta){

    $idPedido = (int)$venta['pedidos_id'];

    $sc = $conexion->prepare("SELECT productos_id, cantidad FROM carrito WHERE pedidos_id=?");
    $sc->bind_param('i', $idPedido);
    $sc->execute();
    $carrito = $sc->get_result();

    while($fila = $carrito->fetch_assoc()){

        $cantidad = (int)$fila['cantidad'];
        $idProducto = (int)$fila['productos_id'];

        $su = $conexion->prepare("UPDATE productos SET stock = stock + ? WHERE id=?");
        $su->bind_param('ii', $cantidad, $idProducto);
        $su->execute();
    }

    $sd = $conexion->prepare("DELETE FROM ventas WHERE id=?");
    $sd->bind_param('i', $id);
    $sd->execute();

    $sp = $conexion->prepare("UPDATE pedidos SET estado='En proceso', metodo_pago='' WHERE id=?");
    $sp->bind_param('i', $idPedido);
    $sp->execute();
}

header("Location: ventas.php");
exit();
?>