<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conexion=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conexion->error) {
        echo "hubo un error al conectar a las base de datos";
}
$nombre=$_POST['nombre'];
$descripcin=$_POST['descripcion'];
$precio=$_POST['precio'];
$costo=$_POST['costo'];
$stock=$_POST['stock'];
$sql ="INSERT INTO producto(nombre, descripcion, precio, costo, stock) VALUES ('$nombre', '$descripcin', '$precio', '$costo', '$stock')";
if ($conexion->query($sql)===TRUE){
  echo "Se registro correctamente";
}
else{
  echo $sql->error;
}

?>