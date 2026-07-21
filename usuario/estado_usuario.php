<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/04.vendedor.php"); exit(); }
include("../conexion.php");
$ci=isset($_GET['ci'])?$_GET['ci']:0; $r=$conexion->query("SELECT * FROM usuario WHERE ci='$ci' AND rol='Vendedor'"); if($r->num_rows>0){$f=$r->fetch_assoc();$nuevo=$f['estado']=='Activo'?'Bloqueado':'Activo';$conexion->query("UPDATE usuario SET estado='$nuevo' WHERE ci='$ci'");} header("Location: read.all.usuario.php"); exit(); ?>