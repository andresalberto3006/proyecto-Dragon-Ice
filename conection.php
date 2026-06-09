<?php
function connection(){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "dragonice";

    $connect=new mysqli($ciu, $nombre, $direccion, $celular, $rol, $estado);

    if ($conn->connect_error) {
die("Conexión fallida: " . $conn->connect_error);
}

    return $connect;

}


?>