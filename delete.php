<?php
    $servidor="localhost";
    $usuario="root";
    $contraseña="";
    $nombreBD="dragonice";

    $conexion= new mysqli($servidor,$usuario,$contraseña,$nombreBD);
    if($conexion -> connect_error){
        echo "no te conectaste";
    }
    else{
        echo "si te conectaste "."<br>";
    }
    if (isset($_GET['id'])) {
        $id=$_GET['id'];
        echo "<h3>se eliminara:</h3>".$id;

        $sql ="DELETE FROM produc WHERE id =$id";

    if($conexion->query($sql) === TRUE){
        echo "<h1>se elimino correctamente</h1>";
    }
    } 
    else {
    echo "No se recibió ningún ID.";
}