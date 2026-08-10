<?php
include("../conexion.php");
?>

<?php
$direccion="localhost";
$usuario="root";
$contrasena="";
$nombreBase="dragonice";

$conexion= new mysqli($direccion,$usuario,$contrasena,$nombreBase);
if($conexion->error){
    echo "Hubo un error al conectar a la base de datos";
}
?>