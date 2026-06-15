<?php
   $direccion="localhost";
   $usuario="root";
   $contraseña="";
   $nombreBase="dragonice";

   $conexion= new mysql($direccion,$usuario,$contraseña,$nombreBase);
   if($conexion->error){
    echo "hubo un error al conectar a la base de datos";
   }

   $codigo=$_GET['codigo'];
   $sql="SELECT * FROM producto WHERE codigo='$codigo";
   $resultado = $conexion->query($sql);
   if ($resultado->num_rouws>0){
    while($fila=$rsultado->fetch_assoc()){
        echo $fila['codigo']."<br>".$fila['nombre']."<br>".$fila['descripcion']."<br>".$fila['precio']."<br>".$fila['costo']."<br>".$fila['stock'];   
    }
   }

?>