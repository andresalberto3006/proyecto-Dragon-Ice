<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $connect=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        echo "hubo un error al conectar a las base de datos";
}
$id=$_POST['ciu'];
$nombre=$_POST['nombre'];
$fecha=$_POST['direccion'];
$estado=$_POST['celular'];
$nombrevendedor=$_POST['rol'];
$sql ="INSERT INTO pedidos(id, nombre, estado, estado, nombrevendedor) VALUES ('$ciu', '$nombre', '$direccion', '$celular', '$rol', '$estado')";
if ($conexion->query($sql)==TRUE){
  echo "Se registro correctamente";
}
else{
  echo $sql->error;
}

?>