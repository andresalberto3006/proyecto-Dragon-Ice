<?php
session_start();require 'conexion.php';header('Content-Type: application/json; charset=utf-8');if(!isset($_SESSION['pedido'])){echo json_encode(['ok'=>false,'mensaje'=>'No existe pedido activo']);exit;}$id=(int)$_SESSION['pedido'];
$s=$conn->prepare('SELECT id,nombre AS Nombre,telefono,direccion,metodo_pago AS metodoPago,estado AS Estado,nombrevendedor AS NombreVendedor FROM pedidos WHERE id=? LIMIT 1');$s->bind_param('i',$id);$s->execute();$p=$s->get_result()->fetch_assoc();if($p)echo json_encode(['ok'=>true,'pedido'=>$p]);else{unset($_SESSION['pedido']);echo json_encode(['ok'=>false,'mensaje'=>'Pedido no encontrado']);}
?>
