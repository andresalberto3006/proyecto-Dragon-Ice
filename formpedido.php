<?php
session_start();

if(!isset($_SESSION["usuario"])){
    header("Location: iniciosesion.php");
    exit();
}

include("conexion.php");

$usuario=$_SESSION["usuario"];

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dragon Ice | Nuevo Pedido</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,Helvetica,sans-serif;
}

body{

background-image:url("1 (4).png");
background-size:cover;
background-position:center;
background-attachment:fixed;

}

.contenedor{

width:100%;
min-height:100vh;

display:flex;

justify-content:center;

align-items:center;

padding:30px;

}

.tarjeta{

width:450px;

background:rgb(125,197,197);

border-radius:25px;

padding:35px;

box-shadow:0 15px 35px rgba(0,0,0,.4);

}

.tarjeta h1{

text-align:center;

color:white;

margin-bottom:25px;

}

label{

display:block;

margin-top:15px;

font-weight:bold;

color:white;

}

input{

width:100%;

padding:12px;

margin-top:5px;

border:none;

border-radius:10px;

font-size:16px;

}

button{

width:100%;

padding:15px;

margin-top:25px;

border:none;

background:#0b5ed7;

color:white;

font-size:18px;

cursor:pointer;

border-radius:12px;

transition:.3s;

}

button:hover{

background:#084298;

transform:scale(1.02);

}

</style>

</head>

<body>

<?php include("menu.php");?>

<div class="contenedor">

<div class="tarjeta">

<h1>🍦 Nuevo Pedido</h1>

<form action="nuevo_pedido.php" method="POST">

<label>Cliente</label>

<input
type="text"
name="nombre"
value="<?php echo $usuario;?>"
readonly>

<label>Fecha</label>

<input
type="date"
name="fecha"
value="<?php echo date("Y-m-d");?>"
readonly>

<input
type="hidden"
name="estado"
value="En proceso">

<input
type="hidden"
name="nombrevendedor"
value="<?php echo $usuario;?>">

<button>

Comenzar Compra

</button>

</form>

</div>

</div>

</body>

</html>