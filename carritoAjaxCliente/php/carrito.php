<?php
session_start(); require 'conexion.php'; header('Content-Type: application/json; charset=utf-8');
if(!isset($_SESSION['pedido'])){echo json_encode(['ok'=>false,'mensaje'=>'No existe pedido activo']);exit;}
$idPedido=(int)$_SESSION['pedido']; $accion=$_POST['accion']??'';
switch($accion){
case 'agregar':
 $codigo=(int)($_POST['codigo']??0);
 $s=$conn->prepare('SELECT id,nombre,precio,stock,imagen FROM productos WHERE id=? LIMIT 1'); $s->bind_param('i',$codigo); $s->execute(); $r=$s->get_result();
 if(!$r->num_rows){echo json_encode(['ok'=>false,'mensaje'=>'Producto no encontrado']);exit;} $p=$r->fetch_assoc();
 if((int)$p['stock']<=0){echo json_encode(['ok'=>false,'mensaje'=>'Producto sin stock']);exit;}
 $s=$conn->prepare('SELECT cantidad FROM carrito WHERE pedidos_id=? AND productos_id=? LIMIT 1'); $s->bind_param('ii',$idPedido,$codigo); $s->execute(); $r=$s->get_result();
 if($r->num_rows){$cantidad=(int)$r->fetch_assoc()['cantidad']+1; if($cantidad>(int)$p['stock']){echo json_encode(['ok'=>false,'mensaje'=>'No hay suficiente stock disponible']);exit;} $sub=$cantidad*(float)$p['precio']; $s=$conn->prepare('UPDATE carrito SET cantidad=?,costototal=? WHERE pedidos_id=? AND productos_id=?'); $s->bind_param('idii',$cantidad,$sub,$idPedido,$codigo);}
 else{$cantidad=1;$sub=(float)$p['precio'];$s=$conn->prepare('INSERT INTO carrito(productos_id,pedidos_id,cantidad,costototal) VALUES(?,?,?,?)');$s->bind_param('iiid',$codigo,$idPedido,$cantidad,$sub);}
 echo json_encode($s->execute()?['ok'=>true,'mensaje'=>'Producto agregado correctamente']:['ok'=>false,'mensaje'=>$s->error]); break;
case 'mostrar':
 $s=$conn->prepare('SELECT c.productos_id AS Producto_id,c.cantidad,c.costototal,p.nombre,p.precio,p.imagen FROM carrito c INNER JOIN productos p ON c.productos_id=p.id WHERE c.pedidos_id=?');$s->bind_param('i',$idPedido);$s->execute();$r=$s->get_result();$a=[];while($f=$r->fetch_assoc())$a[]=$f;echo json_encode($a);break;
case 'vaciar':
 $s=$conn->prepare('DELETE FROM carrito WHERE pedidos_id=?');$s->bind_param('i',$idPedido);echo json_encode($s->execute()?['ok'=>true,'mensaje'=>'Carrito vaciado correctamente']:['ok'=>false,'mensaje'=>$s->error]);break;
default: echo json_encode(['ok'=>false,'mensaje'=>'Acción no válida']);
}
$conn->close();
?>
