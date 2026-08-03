<?php
session_start();
if(!isset($_SESSION['rol'])){header("Location: iniciosesion.php");exit();}
if($_SESSION['rol']!='Vendedor'){header("Location: paginaprincipal/02.admin.php");exit();}
include("conexion.php");
if($_SERVER['REQUEST_METHOD']!='POST'){header("Location: formpedido.php");exit();}
$nombre=$_POST['nombre'];$fecha=isset($_POST['fecha'])?$_POST['fecha']:date('Y-m-d');$ci=$_SESSION['ci'];$vendedor=$_SESSION['usuario'];
$sql="INSERT INTO pedidos(nombre,fecha,estado,vendedor_ci,nombrevendedor,metodo_pago) VALUES('$nombre','$fecha','Pendiente','$ci','$vendedor','')";
if($conexion->query($sql)){ $idPedido=$conexion->insert_id; header("Location: miCarrito.php?idPedido=$idPedido"); exit(); }
echo "No se pudo crear el pedido";
?>