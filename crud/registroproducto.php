<?php
  $direccion="localhost";
  $usuario="root";
  $contraseña="";
  $nombreBase="dragonice";

  $conn = new mysqli($direccion, $usuario, $contraseña, $nombreBase);
  if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
  }
  if ($_POST["REQUEST_METHOD"] == "POST"){


      $id = $_POST['id']; 
      $nombre = $_POST['nombre'];
      $descripcion = $_POST['descripcion'];
      $precio = $_POST['precio'];
      $costo = $_POST['costo'];
      $stock = $_POST['stock'];

      $sql = "INSERT INTO productos (id, nombre, descripcion, precio, costo, stock) 
              VALUES ('$id', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";

      if ($conn->query($sql) === TRUE) {
          echo " Producto registrado correctamente";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }
?>




