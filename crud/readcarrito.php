<?php
   $direccion="localhost";
   $usuario="root";
   $contraseña="";
   $nombreBase="dragonice";

   $conexion= new mysqli($direccion,$usuario,$contraseña,$nombreBase);
   if($conexion->error){
    echo "hubo un error al conectar a la base de datos";
   }

   $id_productos=$_GET['id_productos'];
   $id_pedidos=$_GET['id_pedidos'];
   $sql="SELECT * FROM usuario WHERE ciu='$ciu";
   $resultado = $conexion->query($sql);
   if ($resultado->num_rouws>0){
    while($fila=$rsultado->fetch_assoc()){
        echo $fila['id_productos']."<br>".$fila['id_pedidos']."<br>".$fila['cantidad']."<br>".$fila['costotal'];   
    }
   }

?>