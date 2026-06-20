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
    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $costo = $_POST['costo'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO productos (id, nombre, descripcion, precio, costo, stock) 
            VALUES ('$id', '$nombre', '$descripcion', '$precio', '$costo', '$stock')";

    if($conn->query($sql) === TRUE) {
        
?>
<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro Exitoso</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
}

.tarjeta{

    width:550px;

    background-color: #c2e0ff;

    padding:45px;

    border-radius:25px;

    text-align:center;

    box-shadow:0 10px 35px rgba(0,0,0,0.25);
}

.icono{
    font-size:90px;
    margin-bottom:20px;
}

h1{
    color:#18335c;
    margin-bottom:15px;
}

.mensaje{
    font-size:20px;
    color:#555;
    line-height:1.8;
}

.usuario{
    color:#2f5d9f;
    font-weight:bold;
}

.boton{

    display:inline-block;

    margin-top:30px;

    text-decoration:none;

    background:#4da6ff;

    color:white;

    padding:14px 35px;

    border-radius:12px;

    font-size:18px;

    font-weight:bold;

    transition:.3s;
}

.boton:hover{
    background:#2f5d9f;
}

</style>

</head>

<body>

<div class="tarjeta">

<div class="icono">🍦✅</div>

<h1>¡Registro Exitoso!</h1>

<p class="mensaje">
    El producto
    <span class="productos"><?php echo $nombre; ?></span>
    fue registrado correctamente.
</p>

<a href="../formularios/06.formularioproducto.php" class="boton">
    Registrar otro producto
</a>


</div>

</body>
</html>

<?php

    }else{

        echo "Error: ".$conn->error;

    }

}

$conn->close();

?>
     




