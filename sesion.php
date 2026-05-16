<?php
  $direccion="localhost";
   $usuario="root";
   $contraseña=""
   $nombreBase="" 

<<<<<<< Updated upstream
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

   $ci=$_POST['ci'];
   $nombre=$_POST['nombre'];
   $direccion=$_POST['direccion'];
   $celular=$_POST['celular'];
   $rol=$_POST['rol'];
   $estado=$_POST['estado'];
   $sql ="INSERT INTO personas(ci, nombre, direccion, celular, rol, estado) VALUES ('$ci' , '$nombre' , '$direccion' , '$celular' , '$rol' , '$estado')";
   if($conexion->query($sql)===TRUE){
    echo "se registro correctamente";
   }

>>>>>>> Stashed changes
?>