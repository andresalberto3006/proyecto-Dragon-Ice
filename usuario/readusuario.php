<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/vendedor20.php"); exit(); }
include("../conexion.php");

$ci = isset($_GET['ci']) ? $_GET['ci'] : 0;
$resultado = $conexion->query("SELECT * FROM usuario WHERE ci='$ci'");

$rutaMenu = "../";
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuario Registrado</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

html, body{
    height:100%;
}

body{
    display:flex;
    flex-direction:column;
    min-height:100vh;
}

.fondo-panel{
    flex:1;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:40px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.tarjeta{

    width:650px;

    background:white;

    padding:40px;

    border-radius:25px;

    box-shadow:0 10px 30px rgba(0,0,0,0.25);
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

strong{
    color:#18335c;
}

.botones{
    margin-top:30px;
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

    transition:.3s;
}

.boton:hover{
    background:#2f5d9f;
}

</style>

</head>

<body>

<?php include("../menu.php"); ?>

<main class="fondo-panel">
<div class="tarjeta">
<h1> Información del Usuario</h1>
<?php if($resultado->num_rows>0){ $fila=$resultado->fetch_assoc(); ?>
<div class="dato"><strong>CI:</strong> <?php echo $fila['ci']; ?></div>
<div class="dato"><strong>Nombre:</strong> <?php echo $fila['nombre']; ?></div>
<div class="dato"><strong>Dirección:</strong> <?php echo $fila['direccion']; ?></div>
<div class="dato"><strong>Celular:</strong> <?php echo $fila['celular']; ?></div>
<div class="dato"><strong>Rol:</strong> <?php echo $fila['rol']; ?></div>
<div class="dato"><strong>Estado:</strong> <?php echo $fila['estado']; ?></div>
<?php } else { ?>
<div class="dato">Usuario no encontrado.</div>
<?php } ?>
<div class="botones">
<a href="read.all.usuario.php" class="boton">Ver todos los usuarios</a>
<a href="formulariousuario.php" class="boton">Registrar Usuario</a>
</div>
</div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>