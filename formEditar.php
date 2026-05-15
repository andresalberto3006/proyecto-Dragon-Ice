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
    $ciu=$fila[ciu];
    $fila[nombre]."<br>".$fila[direccion]."<br>".$fila[celular]."<br>".$fila[rol];
  }
}
?>