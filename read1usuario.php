<?php
$direccion="localhost";
$usuario="rout";
$contraseña="";
$nombrebase="dragonice";

$conexion= new mysqli($direccion,$usuario,$contraseña,$nombrebase);
if($conexion->error){
    echo "hubo un error al conectar con la base de datos";
}

$sql="SELECT *FROM personas ;
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila=$resultado->fetch_assoc()){
echo $fila['ciu']."<br>".$fila[nombre]."<br>".$fila[direccion]."<br>".$fila[celular]."<br>".$fila[rol];
  $idPersonas=$fila["id"];
  echo "<a href=
  }
}
?>