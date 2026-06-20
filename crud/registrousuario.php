<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conn=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] === "POST"){

$ci=$_POST['ci'];
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$celular=$_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];

$sql = "INSERT INTO usuario (ciu, nombre, direccion, celular, rol, estado)
        VALUES ('$ciu','$nombre', '$direccion', '$celular', '$rol', '$estado')";
 
 if ($conn->query($sql) === TRUE){
          echo " Usuario registrado correctamente";

          //header("Location: readusuario.php?ciu=$ciu");
          echo "Error: " . $conn->error;

$sql ="INSERT INTO usuario(ci, nombre, direccion, celular, rol, estado) VALUES ('$ci','$nombre', '$direccion', '$celular', '$rol', '$estado')";
  if ($conn->query($sql)===TRUE){
          echo " Usuario registrado correctamente";
          //header("Location: readusuario.php?ci=$ci");
      } else {
          echo " Error: " . $conn->error;

      }
  }

?>