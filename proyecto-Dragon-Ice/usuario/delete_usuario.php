<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Error al conectar a la base de datos");
}

$ci = $_GET['ci'];

$sql = "DELETE FROM usuario WHERE ci='$ci'";

$eliminado = false;

if($conn->query($sql) === TRUE){
    $eliminado = true;
}

?>
<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/04.vendedor.php"); exit(); }
include("../conexion.php");
$ci=isset($_GET['ci'])?$_GET['ci']:0;
if($ci==$_SESSION['ci']){echo "<script>alert('No puede eliminar su propia cuenta.');window.location='read.all.usuario.php';</script>";exit();}
$r=$conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE vendedor_ci='$ci'")->fetch_assoc();
if($r['total']>0){echo "<script>alert('No se puede eliminar porque tiene pedidos registrados. Puede bloquearlo.');window.location='read.all.usuario.php';</script>";exit();}
$conexion->query("DELETE FROM usuario WHERE ci='$ci'"); header("Location: read.all.usuario.php"); exit(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eliminar Usuario</title>

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

h1{
    margin-bottom:15px;
}

.exito{
    color:#28a745;
}

.error{
    color:#dc3545;
}

.mensaje{
    font-size:18px;
    color:#555;
    margin-bottom:25px;
}

.botones{
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
}

.boton{
    text-decoration:none;
    background:#4da6ff;
    color:white;
    padding:12px 25px;
    border-radius:10px;
    font-weight:bold;
    transition:.3s;
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

<h1 class="exito">
    Usuario eliminado correctamente
</h1>

<p class="mensaje">
    El usuario con CI <strong><?php echo $ci; ?></strong> fue eliminado exitosamente.
</p>

<?php } else { ?>

<div class="icono">❌</div>

<h1 class="error">
    Error al eliminar usuario
</h1>

<p class="mensaje">
    <?php echo $conn->error; ?>
</p>

<?php } ?>

<div class="botones">

    <a href="read.all.usuario.php" class="boton">
        Ver todos los usuarios
    </a>

    <a href="../formularios/05.formulariousuario.php" class="boton">
        Registrar usuario
    </a>

</div>

</div>

</body>
</html>

<?php
$conn->close();
?>