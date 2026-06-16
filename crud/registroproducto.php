<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $connect=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        echo "hubo un error al conectar a las base de datos";
}
$Codigo=$_POST['Codigo'];
$nombre=$_POST['nombre'];
$descripcin=$_POST['direccion'];
$precio=$_POST['celular'];
$costo=$_POST['rol'];
$stock=$_POST['estado'];
$sql ="INSERT INTO producto(Codigo, nombre, descripcion, precio, costo, stock) VALUES ('$id', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";
if ($conexion->query($sql)==TRUE){
  echo "Se registro correctamente";
  header("Location: readproductoi.php");
}
else{
  echo $sql->error;
}

?>