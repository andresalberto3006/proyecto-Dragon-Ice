<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $connect=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        echo "hubo un error al conectar a las base de datos";
}
$id_productos=$_POST['ciu'];
$id_pedidos=$_POST['nombre'];
$cantidad=$_POST['direccion'];
$costotal=$_POST['celular'];
$sql ="INSERT INTO productos_has_pedidos(id_productos, id_pedidos, cantidad, costotal, rol, estado) VALUES ('$ciu', '$nombre', '$direccion', '$celular', '$rol', '$estado')";
if ($conexion->query($sql)==TRUE){
  echo "Se registro correctamente";
}
else{
  echo $sql->error;
}

?>