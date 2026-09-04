<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json; charset=utf-8');

$d = json_decode(file_get_contents('php://input'), true);

if(!$d){
    echo json_encode(['ok'=>false,'mensaje'=>'No se recibieron datos']);
    exit;
}

$nombre    = isset($d['nombre'])    ? trim($d['nombre'])    : '';
$telefono  = isset($d['telefono'])  ? trim($d['telefono'])  : '';
$direccion = isset($d['direccion']) ? trim($d['direccion']) : '';
$metodo    = isset($d['metodo'])    ? trim($d['metodo'])    : '';

if($nombre===''||$telefono===''||$direccion===''||$metodo===''){
    echo json_encode(['ok'=>false,'mensaje'=>'Completa todos los datos del pedido.']);
    exit;
}

if(isset($_SESSION['pedido'])){
    echo json_encode(['ok'=>true,'pedido'=>$_SESSION['pedido'],'sesion'=>$_SESSION['pedido'],'mensaje'=>'Ya existe un pedido activo.']);
    exit;
}

$s = $conn->prepare("INSERT INTO pedidos(nombre,fecha,estado,vendedor_ci,nombrevendedor,metodo_pago,telefono,direccion) VALUES(?,CURDATE(),'Abierto',NULL,NULL,?,?,?)");

if(!$s){
    echo json_encode(['ok'=>false,'mensaje'=>'Error al preparar el pedido: '.$conn->error]);
    exit;
}

$s->bind_param('ssss', $nombre, $metodo, $telefono, $direccion);

if($s->execute()){
    $_SESSION['pedido'] = $conn->insert_id;
    echo json_encode(['ok'=>true,'pedido'=>$_SESSION['pedido'],'sesion'=>$_SESSION['pedido']]);
}else{
    echo json_encode(['ok'=>false,'mensaje'=>'Error al crear pedido: '.$s->error]);
}
?>