<?php
$direccion="localhost";
$usuario="rout";
$contraseña="";
$nombreBase="dragonice";

$conexion= new mysqli($direccion,$usuario,$contraseña,$nombreBase);
if($conexion->error){
    echo "hubo un error al conectar con la base de datos";
}
$id-$_GET['id']
$sql="SELECT *FROM personas WHERE id="$id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila=$resultado->fetch_assoc()){
    $idu=$fila['idp'];
    $nombreu=$fila[nombrep];
    $direccion=$fila[direccion];
    $celular=$fila[costo];
    $rol=$fila[stock];
  }
}
?>
