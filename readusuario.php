<?php

include("conexion.php");

$usuarios = mysqli_query(
$conexion,
"SELECT * FROM usuario"
);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista de Usuarios</title>

<style>

body{
    font-family:Arial;
    background:#7ec7ff;
    padding:30px;
}

h1{
    text-align:center;
    margin-bottom:25px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#182d4b;
    color:white;
    padding:12px;
}

td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

.editar{
    background:#4da6ff;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    text-decoration:none;
}

.eliminar{
    background:red;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    text-decoration:none;
}

.inicio{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    background:#182d4b;
    color:white;
    padding:10px 15px;
    border-radius:10px;
}

</style>
</head>

<body>

<a href="formulariousuario.html" class="inicio">
← Volver al formulario
</a>

<h1>Lista de Usuarios</h1>

<table>

<tr>
<th>CIU</th>
<th>Nombre</th>
<th>Dirección</th>
<th>Celular</th>
<th>Rol</th>
<th>Estado</th>
<th>Acciones</th>
</tr>

<?php while($fila = mysqli_fetch_assoc($usuarios)){ ?>

<tr>

<td><?php echo $fila['ciu']; ?></td>
<td><?php echo $fila['nombre']; ?></td>
<td><?php echo $fila['direccion']; ?></td>
<td><?php echo $fila['celular']; ?></td>
<td><?php echo $fila['rol']; ?></td>
<td><?php echo $fila['estado']; ?></td>

<td>

<a class="editar"
href="editar.php?ciu=<?php echo $fila['ciu']; ?>">
Editar
</a>

<a class="eliminar"
href="eliminar.php?ciu=<?php echo $fila['ciu']; ?>"
onclick="return confirm('¿Eliminar usuario?')">
Eliminar
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>