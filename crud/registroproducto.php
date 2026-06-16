<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conexion=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        echo "hubo un error al conectar a las base de datos";
}
$Codigo=$_POST['ci'];
$nombre=$_POST['nombre'];
$descripcin=$_POST['descripcion'];
$precio=$_POST['precio'];
$costo=$_POST['costo'];
$stock=$_POST['stock'];
$sql ="INSERT INTO producto(ci, nombre, descripcion, precio, costo, stock) VALUES ('$Codigo', '$nombre', '$descripcin', '$precio', '$costo', '$stock')";
if ($conexion->query($sql)==TRUE){
  echo "Se registro correctamente";
}
else{
  echo $sql->error;
}

?>