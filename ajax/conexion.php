<?php

$host="localhost";
$usuario="root";
$password="";
$bd="dragonice";

$conn=new mysqli($host,$usuario,$password,$bd);

if($conn->connect_error){
    die("Error de conexión");
}

$conn->set_charset("utf8");