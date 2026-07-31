<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conexion=new mysqli($direccion,$usuario,$contraseña,$nombreBase);
    if ($conexion->error) {
        echo "hubo un error al conectar a las base de datos";
}
$codigo =$_POST['codigo'];
$nombre=$_POST['nombre'];
$descripcin=$_POST['descripcion'];
$precio=$_POST['precio'];
$costo=$_POST['costo'];
$stock=$_POST['stock'];
$sql ="INSERT INTO productos("codigo", nombre, descripcion, precio, costo, stock) VALUES ('$codigo','$nombre', '$descripcion', '$precio', '$costo', '$stock')";
if ($conexion->query($sql)===TRUE){
  echo "Se registro correctamente";
  // header("Location: readproductoi.php");
}
else{
  echo $sql->error;
}

?> 