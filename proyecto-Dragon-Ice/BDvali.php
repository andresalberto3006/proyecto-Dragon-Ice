<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: iniciosesion.php");
    exit();
}

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$sql = "SELECT * FROM usuario WHERE nombre='$usuario' AND celular='$clave' LIMIT 1";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();

    if ($fila['estado'] == 'Bloqueado') {
        echo "<script>alert('Este usuario está bloqueado.'); window.location='iniciosesion.php';</script>";
        exit();
    }

    if ($fila['rol'] != 'Administrador' && $fila['rol'] != 'Vendedor') {
        echo "<script>alert('El rol del usuario no es válido.'); window.location='iniciosesion.php';</script>";
        exit();
    }

    $_SESSION['ci'] = $fila['ci'];
    $_SESSION['usuario'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];

    if ($fila['rol'] == 'Administrador') {
        header("Location: paginaprincipal/02.admin.php");
    } else {
        header("Location: paginaprincipal/04.vendedor.php");
    }
    exit();
}

echo "<script>alert('Nombre o número de celular incorrectos.'); window.location='iniciosesion.php';</script>";
?>

