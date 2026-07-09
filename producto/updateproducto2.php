<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Error de conexión");
}

$id=$_POST['id'];
$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$precio=$_POST['precio'];
$costo=$_POST['costo'];
$stock=$_POST['stock'];

$sql="UPDATE productos SET

nombre='$nombre',
descripcion='$descripcion',
precio='$precio',
costo='$costo',
stock='$stock'

WHERE id='$id'";

$actualizado=false;

if($conn->query($sql)===TRUE){
    $actualizado=true;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Producto Actualizado</title>

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

width:600px;

background:white;

padding:40px;

border-radius:25px;

text-align:center;

box-shadow:0 10px 30px rgba(0,0,0,.25);

}

.icono{
font-size:80px;
margin-bottom:20px;
}

.exito{
color:#28a745;
}

.error{
color:#dc3545;
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

<body>

<div class="tarjeta">

<?php if($actualizado){ ?>

<div class="icono">✅🍦</div>

<h1 class="exito">
Producto actualizado correctamente
</h1>

<p>
Los cambios fueron guardados exitosamente.
</p>

<?php } else { ?>

<div class="icono">❌</div>

<h1 class="error">
Error al actualizar
</h1>

<p>
<?php echo $conn->error; ?>
</p>

<?php } ?>

<br><br>

<a href="read.all.producto.php" class="boton">
Ver todos los productos
</a>

</div>

</body>
</html>

<?php
$conn->close();
?>