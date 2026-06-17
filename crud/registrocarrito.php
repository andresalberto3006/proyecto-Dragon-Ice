<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conexion=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        echo "hubo un error al conectar a las base de datos";
}
$id_productos=$_POST['id_productos'];
$id_pedidos=$_POST['id_pedidos'];
$cantidad=$_POST['cantidad'];
$costotal=$_POST['costotal'];
$sql ="INSERT INTO productos_has_pedidos(id_productos, id_pedidos, cantidad, costotal) VALUES ('$id_productos', '$id_pedidos', '$cantidad', '$costotal')";
if ($conexion->query($sql)==TRUE){
  echo "Se registro correctamente";
  header("Location: readcarrito.php?id_productos=$id_productos");
}
else{
  echo $sql->error;
}

?>