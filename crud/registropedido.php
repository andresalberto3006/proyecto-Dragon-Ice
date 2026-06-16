<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conexion=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        echo "hubo un error al conectar a las base de datos";
}
$id=$_POST['id'];
$nombre=$_POST['nombre'];
$fecha=$_POST['fecha'];
$estado=$_POST['estado'];
$nombrevendedor=$_POST['nombrevendedor'];
$stock=$_POST['stock'];
$sql ="INSERT INTO producto(id, nombre, fecha, estado, nombrevendedor) VALUES ('$id', '$nombre', '$fecha', '$estado', '$nombrevendedor', '$stock')";
if ($conexion->query($sql)==TRUE){
  echo "Se registro correctamente";
  header("Location: readproductoi.php");
}
else{
  echo $sql->error;
}

?>