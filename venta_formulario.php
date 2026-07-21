<?php
session_start();if(!isset($_SESSION['rol'])||$_SESSION['rol']!='Vendedor'){header("Location: iniciosesion.php");exit();}include("conexion.php");$id=isset($_GET['id'])?$_GET['id']:0;$ci=$_SESSION['ci'];$r=$conexion->query("SELECT p.*,IFNULL(SUM(c.costototal),0) AS total FROM pedidos p LEFT JOIN carrito c ON p.id=c.pedidos_id WHERE p.id='$id' AND p.vendedor_ci='$ci' AND p.estado='En proceso' GROUP BY p.id,p.nombre,p.fecha,p.estado,p.vendedor_ci,p.nombrevendedor,p.metodo_pago");if($r->num_rows==0){header("Location: pedidos.php");exit();}$p=$r->fetch_assoc();?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Venta</title>
<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,Helvetica,sans-serif;
}

body{

background-image:url("1 (4).png");
background-size:cover;
background-position:center;
background-attachment:fixed;

}

.contenedor{

width:100%;
min-height:100vh;

display:flex;

justify-content:center;

align-items:center;

padding:30px;

}

.tarjeta{

width:450px;

background:rgb(125,197,197);

border-radius:25px;

padding:35px;

box-shadow:0 15px 35px rgba(0,0,0,.4);

}

.tarjeta h1{

text-align:center;

color:white;

margin-bottom:25px;

}

label{

display:block;

margin-top:15px;

font-weight:bold;

color:white;

}

input{

width:100%;

padding:12px;

margin-top:5px;

border:none;

border-radius:10px;

font-size:16px;

}

button{

width:100%;

padding:15px;

margin-top:25px;

border:none;

background:#0b5ed7;

color:white;

font-size:18px;

cursor:pointer;

border-radius:12px;

transition:.3s;

}

button:hover{

background:#084298;

transform:scale(1.02);

}

</style>
</head>
<body><?php $rutaMenu="";include("menu.php");?><div class="contenedor"><div class="tarjeta"><h1>🍦 Registrar Venta</h1><form action="registrarVenta.php" method="POST"><input type="hidden" name="idPedido" value="<?php echo $p['id'];?>"><label>Cliente</label><input type="text" value="<?php echo $p['nombre'];?>" readonly><label>Total</label><input type="text" value="Bs. <?php echo $p['total'];?>" readonly><label>Método de pago</label><input type="text" name="metodo_pago" placeholder="Efectivo o transferencia" required><button type="submit">Guardar venta</button></form></div></div></body></html>