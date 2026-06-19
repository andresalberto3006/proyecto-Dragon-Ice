<?php
   $direccion="localhost";
   $usuario="root";
   $contraseña="";
   $nombreBase="dragonice";

   $conexion= new mysqli($direccion,$usuario,$contraseña,$nombreBase);
   if($conexion->error){
    echo "hubo un error al conectar a la base de datos";
   }

   $ci=$_GET['ci'];
   $sql="SELECT * FROM usuario WHERE ci='$ci'";
   $resultado = $conexion->query($sql);
   if ($resultado->num_rows>0){
    while($fila=$resultado->fetch_assoc()){
        echo $fila['ci']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado']; 
          
    }
   }

?>