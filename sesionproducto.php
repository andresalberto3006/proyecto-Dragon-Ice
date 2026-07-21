<?php
  $direccion="localhost";
   $usuario="root";
   $contraseña="";
   $nombreBase="dragonice";

   $conexion= new mysqli{$direccion,$usuario,$contraseña,$nombreBase};
   if($conexion->connect_error){
    echo "hubo un error al conectar a la base de datos";
   }
   session_start();
   if(!isset($_SESSION['ci'])){
     header("location:login.html"); 
     exit();
   }

   $id=$_POST['codigo'];
   $nombre=$_POST['nombre'];
   $descripcion=$_POST['descripcion'];
   $precio=$_POST['precio'];
   $costo=$_POST['costo'];
   $stock=$_POST['stock'];
   $sql ="INSERT INTO productos(id, nombre, descripcion, precio, costo, stock) VALUES ('$id' , '$nombre' , '$descripcion' , '$precio' , '$costo' , '$stock')";
   if($conexion->query($sql)===TRUE){
    echo "se registro correctamente";
   }
?>
<?php header("Location: producto/formularioproducto.php"); exit(); ?>