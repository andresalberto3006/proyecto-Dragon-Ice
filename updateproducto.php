<?php
    $servidor="localhost";
    $usuario="root";
    $contraseña="";
    $nombreBD="admin1";

    $conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);
    if($conn -> connect_error){
        echo "no te conectaste ";
    }
    else{
        echo "si te conectaste ". "<br>";
    }

    $codigo=$_POST['codigo'];
    $nombre=$_POST['nombre'];
    $descripcion=$_POST['descripcion'];
    $precio=$_POST['precio'];
    $costo=$_POST['costo'];
    $stock=$_POST['stock'];

    $sql="UPDATE adminis SET producto='$producto', codigo='$codigo', nombre='$nombre', descripcion='$descripcion', precio='$precio', costo='$costo', stock='$stock' WHERE codigo='$codigo'";
    $query= mysqli_query($conn,$sql);

    if($query){
        header("location: read2producto.php");
    }