<?php
  $direccion="localhost";
   $usuario="root";
   $contraseña=""
   $nombreBase="dragonice" 

   $conexion= new mysql($direccion, $usuario, $contraseña, $nombre base)
=======
   $conexion= new mysqli{$direccion,$usuario,$contraseña,$nombreBase};
   if($conexion->error){
    echo "hubo un error al conectar a la base de datos";
   }
   sesision_start();
   if(!isset($_SESSION['ci'])){
     header("location:login.html"); 
   }

   $codigo=$_POST['codigo'];
   $nombre=$_POST['nombre'];
   $descripcion=$_POST['descripcion'];
   $precio=$_POST['precio'];
   $costo=$_POST['costo'];
   $stock=$_POST['stock'];
   $sql ="INSERT INTO personas(codigp, nombre, descripcion, precio, costo, stock) VALUES ('$codigo' , '$nombre' , '$descripcion' , '$precio' , '$costo' , '$stock')";
   if($conexion->query($sql)===TRUE){
    echo "se registro correctamente";
   }
?>