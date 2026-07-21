<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'Vendedor') { header("Location: ../iniciosesion.php"); exit(); }
include("../conexion.php");
$id=isset($_GET['id'])?$_GET['id']:0;$resultado=$conexion->query("SELECT * FROM productos WHERE id='$id'"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Producto</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial, Helvetica, sans-serif;
}

body{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
}

.tarjeta{
width:650px;
background:white;
padding:40px;
border-radius:25px;
box-shadow:0 10px 30px rgba(0,0,0,.25);
}

h1{
text-align:center;
color:#18335c;
margin-bottom:30px;
}

.dato{
background:#f4f8ff;
padding:15px;
margin-bottom:15px;
border-left:6px solid #4da6ff;
border-radius:10px;
font-size:18px;
}

.botones{
margin-top:25px;
display:flex;
justify-content:center;
gap:15px;
}

.boton{
text-decoration:none;
background:#4da6ff;
color:white;
padding:12px 25px;
border-radius:10px;
font-weight:bold;
}

.boton:hover{
background:#2f5d9f;
}

</style>
</head>
<body><div class="tarjeta"><h1>🍦 Información del Producto</h1><?php if($resultado->num_rows>0){$fila=$resultado->fetch_assoc();?><div class="dato"><strong>ID:</strong> <?php echo $fila['id'];?></div><div class="dato"><strong>Nombre:</strong> <?php echo $fila['nombre'];?></div><div class="dato"><strong>Descripción:</strong> <?php echo $fila['descripcion'];?></div><div class="dato"><strong>Precio:</strong> <?php echo $fila['precio'];?></div><div class="dato"><strong>Costo:</strong> <?php echo $fila['costo'];?></div><div class="dato"><strong>Stock:</strong> <?php echo $fila['stock'];?></div><div class="dato"><img src="../<?php echo $fila['imagen'];?>" width="180"></div><?php }else{?><div class="dato">Producto no encontrado.</div><?php }?><div class="botones"><a href="read.all.producto.php" class="boton">Ver todos los productos</a><a href="formularioproducto.php" class="boton">Registrar Producto</a></div></div></body></html>