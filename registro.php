<?php
$ciu= "localhost";
$nombre= "root";
$direccion= "root";
$celular= "root";
$rol= "root";
$estado= "root";
$nombrebase= "dragon";
$conexion= new mysqli($ciu,$nombre,$direccion,$celular,$rol,$estado,$nombrebase);
if($conexion->error) {
    echo" Hubo un error al conectar a la base de datos";
}
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$celular=$_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];
$sql ="INSERT INTO personas(nombre,direccion, elular,rol,estado) VALUES ('$nombre', '$direccion', '$celular', '$rol', '$estado')";
if($conexion->query($sql)===TRUE){
    echo "Registro exitoso";
}
else{
    echo $sql->error;
}

?>