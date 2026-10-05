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

if(!preg_match('/^[0-9]{8}$/', $telefono)){
    echo json_encode(['ok'=>false,'mensaje'=>'El teléfono debe tener 8 dígitos.']);
    exit;
}

if($metodo !== 'QR' && $metodo !== 'Efectivo'){
    echo json_encode(['ok'=>false,'mensaje'=>'Método de pago no válido.']);
    exit;
}

if(isset($_SESSION['pedido'])){

    $sid = (int)$_SESSION['pedido'];

    $c = $conn->prepare('SELECT estado FROM pedidos WHERE id=? LIMIT 1');
    $c->bind_param('i', $sid);
    $c->execute();
    $existente = $c->get_result()->fetch_assoc();

    if($existente && $existente['estado'] === 'Abierto'){
        echo json_encode(['ok'=>true,'pedido'=>$sid,'sesion'=>$sid,'mensaje'=>'Ya existe un pedido activo.']);
        exit;
    }

    unset($_SESSION['pedido']);
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