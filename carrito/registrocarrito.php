<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conn=new mysqli($direccion, $usuario, $contraseña, $nombreBase);
    if ($conn->connect_error) {
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
}
$id_productos=$_POST['id_productos'];
$id_pedidos=$_POST['id_pedidos'];
$cantidad=$_POST['cantidad'];
$costotal=$_POST['costotal'];
$sql ="INSERT INTO productos_has_pedidos(id_productos, id_pedidos, cantidad, costotal) VALUES ('$id_productos', '$id_pedidos', '$cantidad', '$costotal')";
if ($conn->query($sql)==TRUE){
  echo "Se registro correctamente";
        echo " Carrito registrado correctamente";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }
?>
<?php header("Location: ../pedidos.php"); exit(); ?>