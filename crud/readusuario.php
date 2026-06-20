<?php
   $direccion="localhost";
   $usuario="root";
   $contraseña="";
   $nombreBase="dragonice";

   $conn= new mysqli($direccion,$usuario,$contraseña,$nombreBase);
   if($conn->connect_error){
    echo "hubo un error al conectar a la base de datos";
   }

   $ciu=$_GET['ciu'];
   $sql="SELECT * FROM usuario WHERE ciu='$ciu'";
   $resultado = $conexion->query($sql);
   if ($resultado->num_rows>0){
    while($fila=$resultado->fetch_assoc()){
        echo $fila['ciu']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado']; 
          
    }
   }

?>