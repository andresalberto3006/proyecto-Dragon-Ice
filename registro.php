<?php
$ciu= "localhost";
$nombreu= "root";
$direccion= "root";
$celular= "root";
$rol= "root";
$estado= "root";
$nombrebase= "dragonice";
$conexion= new mysqli($ciu,$nombreu,$direccion,$celular,$rol,$estado,$nombrebase);
if($conexion->error) {
    echo" Hubo un error al conectar a la base de datos";
}
$nombreu=$_POST['nombre'];
$direccion=$_POST['direccion'];
$celular=$_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];
$sql ="INSERT INTO personas(nombreu, direccion, celular, rol, estado) VALUES ('$nombreu', '$direccion', '$celular', '$rol', '$estado')";
if($conexion->query($sql)===TRUE){
    echo "Registro exitoso";
}
else{
    echo $sql->error;
}

?>