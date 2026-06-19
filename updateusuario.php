<?php
    $servidor="localhost";
    $usuario="root";
    $contraseña="";
    $nombreBase="dragonice";

    $conn= new mysqli($servidor,$usuario,$contraseña,$nombreBD);
    if($conn -> connect_error){
        echo "no te conectaste ";
    }
    else{
        echo "si te conectaste ". "<br>";
    }

    $ci=$_POST['ci'];
    $nombre=$_POST['nombre'];
    $direccion=$_POST['direccion'];
    $celular=$_POST['celular'];
    $rol=$_POST['rol'];
    $estado=$_POST['estado'];

    $sql="UPDATE adminis SET usuario='$usuario', ci='$ci', nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol', estado='$estado' WHERE ci='$ci'";
    $query= mysqli_query($conn,$sql);

    if($query){
        header("location: read1usuario.php");
    }