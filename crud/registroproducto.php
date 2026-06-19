<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conn=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->error) {
      die("Conexión fallida: " . $conn->connect_error);
}
if ($_POST["REQUEST_METHOD"] == "POST") {
$Codigo=$_POST['Codigo'];
$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$precio=$_POST['precio'];
$costo=$_POST['costo'];
$stock=$_POST['stock'];
$sql ="INSERT INTO productos(Codigo, nombre, descripcion, precio, costo, stock) VALUES ('$Codigo', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";
if ($conn->query($sql)===TRUE){
  echo "Se registro correctamente";
 // header("Location: readproducto.php?id=$id");
}else{
       echo "Error: " . $sql . "<br>" . $conn->error;
}

}

?>