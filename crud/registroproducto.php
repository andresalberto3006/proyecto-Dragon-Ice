<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conn=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->error) {
      die("Conexión fallida: " . $conn->connect_error);
}

$id=$_POST['id'];
$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$precio=$_POST['precio'];  
$costo=$_POST['costo'];
$stock=$_POST['stock'];
$sql ="INSERT INTO productos(id, nombre, descripcion, precio, costo, stock) VALUES ('$id', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";
if ($conn->query($sql)===TRUE){
  echo "Se registro correctamente";
  // header("Location: readproducto.php?id=$id");
}
else{
  echo $sql->error;
}

?>