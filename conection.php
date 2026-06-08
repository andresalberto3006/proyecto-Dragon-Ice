<?php
function connection(){
    $host = "localhost";
    $user = "root";
    $pass = "";

    $bd = "dragonice";

    $connect=mysqli_connect($ciu, $nombre, $direccion, $celular, $rol, $estado);

    mysqli_select_db($connect, $bd);

    return $connect;

}


?>