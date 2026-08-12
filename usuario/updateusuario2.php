<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/vendedor20.php"); exit(); }
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") { header("Location: read.all.usuario.php"); exit(); }

$ci = $_POST['ci'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

if ($rol != 'Administrador' && $rol != 'Vendedor') {
    echo "<script>alert('Rol no válido.');window.location='updateusuario.php?ci=$ci';</script>";
    exit();
}
if ($estado != 'Activo' && $estado != 'Bloqueado') {
    echo "<script>alert('Estado no válido.');window.location='updateusuario.php?ci=$ci';</script>";
    exit();
}
if ($rol == 'Administrador') { $estado = 'Activo'; }
if ($ci == $_SESSION['ci']) { $rol = 'Administrador'; $estado = 'Activo'; }

$sql = "UPDATE usuario SET nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol', estado='$estado' WHERE ci='$ci'";
$actualizado = $conexion->query($sql);

$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuario Actualizado</title>

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

.mensaje{

    width:500px;

    background:white;

    padding:40px;

    border-radius:25px;

    text-align:center;

    box-shadow:0 10px 30px rgba(0,0,0,.25);
}

h1{
    margin-bottom:20px;
}

.exito{
    color:#28a745;
}

.error{
    color:#dc3545;
}

p{
    font-size:18px;
    color:#444;
    margin-bottom:25px;
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

<?php include("../menu.php"); ?>

<main class="fondo-panel">
    <div class="mensaje">

        <?php if ($actualizado) { ?>

            <h1 class="exito">✅ Usuario actualizado correctamente</h1>
            <p>Los cambios fueron guardados exitosamente.</p>

        <?php } else { ?>

            <h1 class="error">❌ Error al actualizar</h1>
            <p><?php echo $conexion->error; ?></p>

        <?php } ?>

        <a href="read.all.usuario.php" class="boton">Ver todos los usuarios</a>

    </div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>