<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conexion=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conexion->error) {
        echo "Hubo un error al conectar a la base de datos";
}

$ci=$_POST['ci'];
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$celular=$_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];
$sql ="INSERT INTO usuario(ci, nombre, direccion, celular, rol, estado) VALUES ('$ci''$nombre', '$direccion', '$celular', '$rol', '$estado')";
if ($conexion->query($sql)===TRUE){
  echo "Se registro correctamente";
  header("Location: readusuario.php?ci=$ci");
}
else{
  echo $sql->error;
}

?>