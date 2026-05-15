<?php
$direccion="localhost";
$usuario="rout";
$contraseña="";
$nombreBase="dragon";

$conexion= new mysqli($direccion,$usuario,$contraseña,$nombreBase);
if($conexion->error){
    echo "hubo un error al conectar con la base de datos";
}
$id-$_GET['id']
$sql="SELECT *FROM personas WHERE id="$id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila=$resultado->fetch_assoc()){
    $idu=$fila['idu'];
    $nombreu=$fila[nombre];
    $direccion=$fila[direccion];
    $celular=$fila[celular];
    $rol=$fila[rol];
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
 <form action="registro.php" method="post";
    <label for="">ciu</label>
    <input type="text" name="ciu"><br>
    <input type="text" name="direccion" placeholder="direccion" required>
    <input type="text" name="celular" placeholder="numero de celular" required>
    <input type="text" name="rol" placeholder="rol" required>
    <input type="text" name="estado" placeholder="estado" required>
    <input type="password" name="Contraseña" placeholder="Contraseña" required>
    <button type="submit">Enviar</button>
  </form>
</body>
</html>