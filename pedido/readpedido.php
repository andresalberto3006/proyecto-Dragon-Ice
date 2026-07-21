<?php
   $direccion="localhost";
   $usuario="root";
   $contraseña="";
   $nombreBase="dragonice";

   $conexion= new mysqli($direccion,$usuario,$contraseña,$nombreBase);
   if($conexion->error){
    echo "hubo un error al conectar a la base de datos";
   }

   $id=$_GET['id'];
   $sql="SELECT * FROM pedidos WHERE id='$id'";
   $resultado = $conexion->query($sql);
   if ($resultado->num_rows>0){
    while($fila=$resultado->fetch_assoc()){
        echo $fila['id']."<br>".$fila['nombre']."<br>".$fila['fecha']."<br>".$fila['estado']."<br>".$fila['nombrevendedor'];   
    }
   }

?>
<?php header("Location: ../pedidos.php"); exit(); ?>