<?php
$direccion = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "produccion";
$conexion = new mysqli($direccion,$usuario,$password,$baseDatos);
if($conexion->error) {
    echo" Hubo un error al conectar a la base de datos";
}
$nombre =$_POST['nombre'];
$apellido=$_POST['apellido'];
$descripcion=$_POST['descripcion'];
$sql ="INSERT INTO personas(nombre, apellido, descripcion) VALUES ('$nombre', '$apellido', '$descripcion')";
if($conexion->query($sql)===TRUE){
    echo "Registro exitoso";
}
else{
    echo $sql->error;
}

?>