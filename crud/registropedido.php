<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conn=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
  if ($conn->error) {
      die("Conexión fallida: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){


$id=$_POST['id'];
$nombre=$_POST['nombre'];
$fecha=$_POST['fecha'];
$estado=$_POST['estado'];
$nombrevendedor=$_POST['nombrevendedor'];
$sql ="INSERT INTO pedidos(id, nombre, fecha, estado, nombrevendedor) VALUES ('$id', '$nombre', '$fecha', '$estado', '$nombrevendedor')";
if ($conn->query($sql)==TRUE){
        echo " Pedido registrado correctamente";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }
?>
