<?php

include "conexion.php";


$sql="SELECT * FROM productos";


$resultado=mysqli_query($conn,$sql);


$productos=[];


while($fila=mysqli_fetch_assoc($resultado)){

    $productos[]=$fila;

}


echo json_encode($productos);


?>