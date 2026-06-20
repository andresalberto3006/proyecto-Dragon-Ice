<?php
$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion, $usuario, $contraseña, $nombreBase);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO productos (nombre, descripcion, precio, costo, stock) 
            VALUES ('$nombre', '$descripcion', '$precio', '$costo', '$stock')";

    if ($conn->query($sql) === TRUE) {
        echo " Producto registrado correctamente";
    } else {
        echo " Error: " . $conn->error;
    }
} else {
    echo "Acceso inválido: use el formulario.";
}

$conn->close();
?>



