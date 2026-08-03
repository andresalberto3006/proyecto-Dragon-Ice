<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'Vendedor') { header("Location: ../iniciosesion.php"); exit(); }
include("../conexion.php");
$resultado=$conexion->query("SELECT * FROM productos ORDER BY id DESC"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial, Helvetica, sans-serif;
}

body{
background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
padding:40px;
}

.contenedor{
max-width:1200px;
margin:auto;
background:white;
padding:30px;
border-radius:25px;
box-shadow:0 10px 30px rgba(0,0,0,.25);
}

h1{
text-align:center;
color:#18335c;
margin-bottom:25px;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#4da6ff;
color:white;
padding:15px;
}

td{
padding:12px;
text-align:center;
border-bottom:1px solid #ddd;
}

tr:hover{
background:#f4f8ff;
}

.boton{
text-decoration:none;
color:white;
padding:8px 12px;
border-radius:8px;
font-size:14px;
font-weight:bold;
}

.mostrar{
background:#4da6ff;
}

.editar{
background:#28a745;
}

.eliminar{
background:#dc3545;
}

.acciones{
    display:flex;
    justify-content:center;
    gap:8px;
}

.volver{
    display:block;
    width:250px;
    margin:30px auto 0;
    text-align:center;
    text-decoration:none;
    background:#18335c;
    color:white;
    padding:15px;
    border-radius:10px;
    font-weight:bold;
}

.volver:hover{
    background:#2f5d9f;
}

</style>
</head>
<body><div class="contenedor"><h1>🍦 Lista de Productos Registrados</h1><table><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Costo</th><th>Stock</th><th>Imagen</th><th>Acciones</th></tr><?php if($resultado->num_rows>0){while($fila=$resultado->fetch_assoc()){?><tr><td><?php echo $fila['id'];?></td><td><?php echo $fila['nombre'];?></td><td><?php echo $fila['descripcion'];?></td><td><?php echo $fila['precio'];?></td><td><?php echo $fila['costo'];?></td><td><?php echo $fila['stock'];?></td><td><img src="../<?php echo $fila['imagen'];?>" width="60"></td><td><div class="acciones"><a class="boton mostrar" href="readproducto.php?id=<?php echo $fila['id'];?>">Mostrar</a><a class="boton editar" href="updateproducto.php?id=<?php echo $fila['id'];?>">Editar</a><a class="boton eliminar" href="delete_producto.php?id=<?php echo $fila['id'];?>">Eliminar</a></div></td></tr><?php }}else{?><tr><td colspan="8">No existen productos registrados.</td></tr><?php }?></table><a href="formularioproducto.php" class="volver">➕ Registrar Nuevo Producto</a><?php if($_SESSION['rol']=='Administrador'){?><a href="../paginaprincipal/02.admin.php" class="volver">Volver al panel</a><?php }else{?><a href="../paginaprincipal/04.vendedor.php" class="volver">Volver al panel</a><?php }?></div></body></html>