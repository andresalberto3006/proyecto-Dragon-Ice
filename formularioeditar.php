<?php
$nombreServidor = "localhost";
$usuario = "root";
$contraseña = "";
$basededatos = "dragonice";

$conexion = new mysqli($nombreServidor, $usuario, $contraseña, $basededatos);

if ($conexion->connect_error) {
    echo "Hubo un error :(";
}
$id = $_GET['id'];
$sql = "SELECT * FROM datos WHERE id=$id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $id = $fila['id'];
        $nombre = $fila['NombreCompleto'];
        $Fecha = $fila['Fechadenacimiento'];
        $curso = $fila['Curso'];
        $paralelo = $fila['Paralelo'];
        $codigorude = $fila['Codigorude'];
        $carnetdeidentidad = $fila['Carnetdeidentidad'];
        $telefono = $fila['telefono'];
        $direccion = $fila['direccion'];
        $rol = $fila['rol'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="edita.php" method="post">
        <label for="">Id del Usuario></label>
        <input type="hidden" name="id" value='<?= $id ?>'><br>
        <label for="">Nombre Completo:</label>
        <input type="text" name="NombreCompleto" value='<?= $nombre ?>'><br>
        <label for="">Fecha De Nacimiento</label>
        <input type="DATE" name="Fechadenacimiento" value='<?= $Fecha ?>'><br>
        <label for="">Curso</label>
        <input type="number" name="Curso" value='<?= $curso ?>'><br>
        <label for="">Paralelo</label>
        <input type="text" name="Paralelo" value='<?= $paralelo ?>'><br>
        <label for="">Codigo Rude</label>
        <input type="hidden" name="CodigoRude" value='<?= $codigorude ?>'><br>
        <label for="">Carnet De Identidad</label>
        <input type="number" name="Carnetdeidentidad" value='<?= $carnetdeidentidad ?>'><br>
        <label for="">Telefono</label>
        <input type="number" name="telefono" value='<?= $telefono ?>'><br>
        <label for="">Direccion</label>
        <input type="text" name="direccion" value='<?= $direccion ?>'><br>
        <label for="">Rol</label>
        <input type="text" name="rol" value='<?= $rol ?>'><br>
        <input type="Submit">
    </form>
</body>

</html>