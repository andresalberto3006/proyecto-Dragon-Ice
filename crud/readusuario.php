<?php
   $direccion="localhost";
   $usuario="root";
   $contraseña="";
   $nombreBase="dragonice";

   $conexion= new mysql($direccion,$usuario,$contraseña,$nombreBase);
   if($conexion->error){
    echo "hubo un error al conectar a la base de datos";
   }

   $ciu=$_GET['ciu'];
   $sql="SELECT * FROM usuario WHERE ciu='$ciu";
   $resultado = $conexion->query($sql);
   if ($resultado->num_rouws>0){
    while($fila=$rsultado->fetch_assoc()){
        echo $fila['ciu']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado'];   
    }
   }

?>