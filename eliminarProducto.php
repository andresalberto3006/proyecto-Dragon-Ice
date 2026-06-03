<?php
<<<<<<< HEAD
$servidor="";
$usuario="";
$contraseña="";
$baseDedatos="";

$conn = new mysqli($servidor, $usuario, $contraseña, $baseDedatos);

if ($conn->connect_error){
    die("Conexion fallida: ". $con->connect_error);
}

$codigpo = $_GET['codigo'];

$sql = "DELETE FROM producto WHERE codigo=$codigo";

=======
$servidor ="";
$usuario ="";
$contra ="";
$baseDedatos ="dragonice"

$conn = new mysql($servidor, $usuario, $contra, $baseDedatos);

if (conn->connect_error) {
    die("conexion fallida; " . $conn->connect_error);
}

$codigo = $_GET['codigo'];

$sql = "DELETE FROM productos WERE codigo=$codigo";

if ($conn->query($sql) === TRUE){
    echo "Producto eliminado exitosamente";
    header ("Location: readproducto.php");
} else{
    echo "Error " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
>>>>>>> 43e4c216553eae1ded246906a86caf5f7a567fd7
