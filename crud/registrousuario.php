<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $connect=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        echo "Hubo un error al conectar a la base de datos";
}
$ciu=$_POST['ciu'];
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$celular=$_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];
$sql ="INSERT INTO usuario(ciu, nombre, direccion, celular, rol, estado) VALUES ('$ciu', '$nombre', '$direccion', '$celular', '$rol', '$estado')";
if ($conexion->query($sql)==TRUE){
  echo "Se registro correctamente";
  header("Location: readusuario.php");
}
else{
  echo $sql->error;
}

?>