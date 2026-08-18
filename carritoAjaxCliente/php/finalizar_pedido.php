<?php
session_start();require 'conexion.php';header('Content-Type: application/json; charset=utf-8');
if(!isset($_SESSION['pedido'])){echo json_encode(['ok'=>false,'mensaje'=>'No existe pedido']);exit;}$id=(int)$_SESSION['pedido'];
$s=$conn->prepare('SELECT COUNT(*) cantidad FROM carrito WHERE pedidos_id=?');$s->bind_param('i',$id);$s->execute();$r=$s->get_result()->fetch_assoc();if((int)$r['cantidad']===0){echo json_encode(['ok'=>false,'mensaje'=>'El carrito está vacío']);exit;}
$s=$conn->prepare("UPDATE pedidos SET estado='Pendiente' WHERE id=? AND estado='Abierto'");$s->bind_param('i',$id);echo json_encode($s->execute()?['ok'=>true,'pedido'=>$id]:['ok'=>false,'mensaje'=>$s->error]);
?>
