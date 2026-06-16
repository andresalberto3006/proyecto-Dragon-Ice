<?php
    $direccion="localhost";
    $usuario="root";
    $contraseña="";
    $nombreBase="dragonice";

    $conexion= new mysql($direccion, $usuario, $contraseña, $nombreBase);
    if($conexion->error){
        echo "Hubo un error al conectar la base de datos";
    }
    $ciu=$_GET['ciu'];
    $sql="SELECT * FROM usuario WHERE ciu='$ciu'";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows>0){
        while($fila=$resultado->fetch_assoc()){
            $nombre=$fila['nombre'];
            $direccion=$fila['direccion'];
            $celular=$fila['celular'];
            $rol=$fila['rol'];
            $estado=$fila['estado'];
        }
    }
?>