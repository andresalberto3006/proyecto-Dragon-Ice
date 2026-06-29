<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Hubo un error al conectar a la base de datos");
}

$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id='$id'";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Producto</title>

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
width:650px;
background:white;
padding:40px;
border-radius:25px;
box-shadow:0 10px 30px rgba(0,0,0,.25);
}

h1{
text-align:center;
color:#18335c;
margin-bottom:30px;
}

.dato{
background:#f4f8ff;
padding:15px;
margin-bottom:15px;
border-left:6px solid #4da6ff;
border-radius:10px;
font-size:18px;
}

.botones{
margin-top:25px;
display:flex;
justify-content:center;
gap:15px;
}

.boton{
text-decoration:none;
background:#4da6ff;
color:white;
padding:12px 25px;
border-radius:10px;
font-weight:bold;
}

.boton:hover{
background:#2f5d9f;
}

</style>
</head>
<body>

<div class="tarjeta">

<h1>🍦 Información del Producto</h1>

<?php

if($resultado->num_rows>0){

$fila=$resultado->fetch_assoc();

echo "<div class='dato'><strong>ID:</strong> ".$fila['id']."</div>";
echo "<div class='dato'><strong>Nombre:</strong> ".$fila['nombre']."</div>";
echo "<div class='dato'><strong>Descripción:</strong> ".$fila['descripcion']."</div>";
echo "<div class='dato'><strong>Precio:</strong> ".$fila['precio']."</div>";
echo "<div class='dato'><strong>Costo:</strong> ".$fila['costo']."</div>";
echo "<div class='dato'><strong>Stock:</strong> ".$fila['stock']."</div>";

}else{

echo "<div class='dato'>Producto no encontrado</div>";

}

?>

<div class="botones">

<a href="read.all.producto.php" class="boton">
Ver todos los productos
</a>

</div>

</div>

</body>
</html>