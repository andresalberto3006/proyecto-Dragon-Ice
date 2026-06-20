<?php
$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion, $usuario, $contraseña, $nombreBase);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO productos (codigo, nombre, descripcion, precio, costo, stock) 
            VALUES ('$codigo', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";

    if ($conn->query($sql) === TRUE) {
        echo " Se registro correctamente";
        
     // header("Location: readproducto.php?id=$id");
        echo " Error: " . $conn->error;
    }
}




