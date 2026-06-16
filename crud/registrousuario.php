<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conexion=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conexion->error) {
        echo "Hubo un error al conectar a la base de datos";
}
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$celular=$_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];
$sql ="INSERT INTO usuario(nombre, direccion, celular, rol, estado) VALUES ('$nombre', '$direccion', '$celular', '$rol', '$estado')";
if ($conexion->query($sql)===TRUE){
  echo "Se registro correctamente";
}
else{
  echo $sql->error;
}

?>