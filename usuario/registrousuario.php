<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn=new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Conexión fallida: ".$conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"]==="POST"){

    $ci=$_POST['ci'];
    $nombre=$_POST['nombre'];
    $direccion=$_POST['direccion'];
    $celular=$_POST['celular'];
    $rol=$_POST['rol'];
    $estado=$_POST['estado'];

    $sql="INSERT INTO usuario(ci,nombre,direccion,celular,rol,estado)
          VALUES('$ci','$nombre','$direccion','$celular','$rol','$estado')";

    if($conn->query($sql)===TRUE){

?>
<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/04.vendedor.php"); exit(); }
include("../conexion.php");
if ($_SERVER["REQUEST_METHOD"] != "POST") { header("Location: formulariousuario.php"); exit(); }
$ci=$_POST['ci']; $nombre=$_POST['nombre']; $direccion=$_POST['direccion']; $celular=$_POST['celular']; $rol=$_POST['rol']; $estado=$_POST['estado'];
if ($rol!='Administrador' && $rol!='Vendedor') { echo "<script>alert('El rol debe ser Administrador o Vendedor.'); window.location='formulariousuario.php';</script>"; exit(); }
if ($estado!='Activo' && $estado!='Bloqueado') { echo "<script>alert('El estado debe ser Activo o Bloqueado.'); window.location='formulariousuario.php';</script>"; exit(); }
if ($rol=='Administrador') { $estado='Activo'; }
$sql="INSERT INTO usuario(ci,nombre,direccion,celular,rol,estado) VALUES('$ci','$nombre','$direccion','$celular','$rol','$estado')";
if (!$conexion->query($sql)) { echo "<script>alert('No se pudo registrar. Verifique que el CI no esté repetido.'); window.location='formulariousuario.php';</script>"; exit(); }
?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro Exitoso</title>

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

    width:550px;

    background-color: #c2e0ff;

    padding:45px;

    border-radius:25px;

    text-align:center;

    box-shadow:0 10px 35px rgba(0,0,0,0.25);
}

.icono{
    font-size:90px;
    margin-bottom:20px;
}

h1{
    color:#18335c;
    margin-bottom:15px;
}

.mensaje{
    font-size:20px;
    color:#555;
    line-height:1.8;
}

.usuario{
    color:#2f5d9f;
    font-weight:bold;
}

.boton{

    display:inline-block;

    margin-top:30px;

    text-decoration:none;

    background:#4da6ff;

    color:white;

    padding:14px 35px;

    border-radius:12px;

    font-size:18px;

    font-weight:bold;

    transition:.3s;
}

.boton:hover{
    background:#2f5d9f;
}

.botones{
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
}

</style>

</head>

<body><div class="tarjeta"><div class="icono">🍦✅</div><h1>¡Registro Exitoso!</h1><p class="mensaje">El usuario <span class="usuario"><?php echo $nombre; ?></span> fue registrado correctamente.</p><div class="botones"><a href="formulariousuario.php" class="boton">Registrar otro usuario</a><a href="readusuario.php?ci=<?php echo $ci; ?>" class="boton">Ver usuario</a><a href="read.all.usuario.php" class="boton">Ver todos los usuarios</a></div></div></body></html>
