<?php
$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
die("Error al conectar");
}

$id=$_GET['id'];

$sql="DELETE FROM productos WHERE id='$id'";

$eliminado=false;

if($conn->query($sql)===TRUE){
$eliminado=true;
}

?>
<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'Vendedor') { header("Location: ../iniciosesion.php"); exit(); }
include("../conexion.php");
$id=isset($_GET['id'])?$_GET['id']:0;$r=$conexion->query("SELECT COUNT(*) AS total FROM carrito WHERE productos_id='$id'")->fetch_assoc();if($r['total']>0){echo "<script>alert('No se puede eliminar porque el producto pertenece a un pedido.');window.location='read.all.producto.php';</script>";exit();}$conexion->query("DELETE FROM productos WHERE id='$id'");header("Location: read.all.producto.php");exit();?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Eliminar Producto</title>

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

<?php if($eliminado){ ?>

<div class="icono">🗑️✅</div>

<h1>Producto eliminado correctamente</h1>

<p>El producto con ID <?php echo $id; ?> fue eliminado.</p>

<?php } else { ?>

<div class="icono">❌</div>

<h1>Error al eliminar</h1>

<p><?php echo $conn->error; ?></p>

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