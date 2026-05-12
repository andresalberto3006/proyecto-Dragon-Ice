<?php
$nombre="localhost";
$apellido="root";
$descripcion="video";

$conexion= new mysqli($nombre,$apellido,$descripcion);
if($conexion->error){
    echo "hubo un error al conectar con la base de datos";
}
$id-$_GET['id']
$sql="SELECT *FROM personas WHERE id="$id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila=$resultado->fetch_assoc()){
echo $fila['nombre']."<br>".$fila[apellido]."<br>".$fila[descripcion];
  }
}
?>