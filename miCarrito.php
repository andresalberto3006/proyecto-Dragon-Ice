<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: iniciosesion.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "dragonice");

if (!$conexion) {
    die("Error de conexión");
}

$idPedido = $_GET["idPedido"];

// Obtener todos los productos
$sql = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $sql);

// Calcular total del carrito
$sqlTotal = "SELECT SUM(costototal) AS total
             FROM carrito
             WHERE pedidos_id='$idPedido'";

$resTotal = mysqli_query($conexion, $sqlTotal);
$filaTotal = mysqli_fetch_assoc($resTotal);

$total = $filaTotal["total"];

if ($total == NULL) {
    $total = 0;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mi Carrito | Dragon Ice</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial, Helvetica, sans-serif;
}

body{

background-image:url("1 (4).png");

background-size:cover;

background-position:center;

background-attachment:fixed;

color:white;

}

.contenedor{

width:90%;

margin:auto;

padding:40px 0;

}

.tarjeta{

background:rgb(125,197,197);

padding:25px;

border-radius:20px;

margin-bottom:30px;

box-shadow:0 10px 20px rgba(0,0,0,.4);

}

.tarjeta h1{

margin-bottom:10px;

}

table{

width:100%;

border-collapse:collapse;

background:white;

color:black;

border-radius:20px;

overflow:hidden;

}

th{

background:#79ecf0e6;

padding:15px;

}

td{

padding:15px;

text-align:center;

}

tr:nth-child(even){

background:#f5f5f5;

}

input[type=number]{

width:70px;

padding:8px;

border-radius:8px;

border:1px solid gray;

}

button{

padding:10px 18px;

border:none;

background:#0d6efd;

color:white;

border-radius:10px;

cursor:pointer;

transition:.3s;

}

button:hover{

background:#084298;

transform:scale(1.05);

}

.btnNuevo{

margin-top:25px;

}

</style>

</head>

<body>

<?php include("menu.php"); ?>

<div class="contenedor">

<div class="tarjeta">

<h1>🍦 Mi Carrito</h1>

<h2>Pedido #<?php echo $idPedido; ?></h2>

<h2>Total: Bs. <?php echo $total; ?></h2>

</div>

<table>

<tr>

<th>ID</th>

<th>Producto</th>

<th>Descripción</th>

<th>Precio</th>

<th>Cantidad</th>

<th>Agregar</th>

</tr>

<?php

while($fila = mysqli_fetch_assoc($resultado)){

?>

<form action="agregarCarrito.php" method="POST">

<tr>

    <td><?php echo $fila["id"]; ?></td>

    <td><?php echo $fila["nombre"]; ?></td>

    <td><?php echo $fila["descripcion"]; ?></td>

    <td>Bs. <?php echo $fila["precio"]; ?></td>

    <input type="hidden" name="idProducto" value="<?php echo $fila["id"]; ?>">

    <input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>">

    <input type="hidden" name="precio" value="<?php echo $fila["precio"]; ?>">

    <td>

        <input
        type="number"
        name="cantidad"
        min="1"
        value="1"
        required>

    </td>

    <td>

        <button type="submit">

            🛒 Agregar

        </button>

    </td>

</tr>

</form>

<?php

}

?>


</table>

<br><br>

<a href="formPedido.php">

<button class="btnNuevo">

🍦 Nuevo Pedido

</button>

</a>

<hr style="margin:40px 0;">

<div class="tarjeta">

<h2>🛒 Productos Agregados</h2>

<table>

<tr>

<th>Producto</th>
<th>Precio</th>
<th>Cantidad</th>
<th>Subtotal</th>
<th>Eliminar</th>

</tr>

<?php

$sqlCarrito="SELECT
productos.id,
productos.nombre,
productos.precio,
carrito.cantidad,
carrito.costototal

FROM carrito

INNER JOIN productos
ON carrito.productos_id=productos.id

WHERE carrito.pedidos_id='$idPedido'";

$resultadoCarrito=mysqli_query($conexion,$sqlCarrito);

while($carrito=mysqli_fetch_assoc($resultadoCarrito)){

?>

<tr>

<td><?php echo $carrito["nombre"]; ?></td>

<td>Bs. <?php echo $carrito["precio"]; ?></td>

<td><?php echo $carrito["cantidad"]; ?></td>

<td>Bs. <?php echo $carrito["costototal"]; ?></td>

<td>

<a href="eliminarCarrito.php?idProducto=<?php echo $carrito["id"]; ?>&idPedido=<?php echo $idPedido; ?>">

<button style="background:red;">

Eliminar

</button>

</a>

</td>

</tr>

<?php

}

?>

</table>

<br>

<h2 style="text-align:right;">

💰 Total: Bs. <?php echo $total; ?>

</h2>

</div>

</div>

<?php include("piedepagina.php"); ?>

</body>

</html>