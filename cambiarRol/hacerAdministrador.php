<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/vendedor20.php"); exit(); }
include("../conexion.php");

$ci = $_GET['ci'];

$sql = "UPDATE usuario SET rol='Administrador', estado='Activo' WHERE ci='$ci'";

if ($conexion->query($sql)) {
    header("Location: ../usuario/read.all.usuario.php");
} else {
    echo "Error: " . $conexion->error;
}
?>