<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conexion = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conexion->connect_error){
    die("Hubo un error al conectar a la base de datos");
}

$ci= $_GET['ci'];

$sql = "SELECT * FROM usuario WHERE ci='$ci'";

$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){

    $fila = $resultado->fetch_assoc();

    $nombre = $fila['nombre'];
    $direccionUsuario = $fila['direccion'];
    $celular = $fila['celular'];
    $rol = $fila['rol'];
    $estado = $fila['estado'];

}else{

    die("Usuario no encontrado");

}

?>

<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/04.vendedor.php"); exit(); }
include("../conexion.php");
$ci=isset($_GET['ci'])?$_GET['ci']:0; $resultado=$conexion->query("SELECT * FROM usuario WHERE ci='$ci'"); if($resultado->num_rows==0){ die("Usuario no encontrado"); } $fila=$resultado->fetch_assoc(); $nombre=$fila['nombre']; $direccionUsuario=$fila['direccion']; $celular=$fila['celular']; $rol=$fila['rol']; $estado=$fila['estado']; ?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<title>Actualizar Usuario</title>

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

.formulario{

    width:420px;

    padding:35px;

    background:white;

    border-radius:25px;

    box-shadow:0 10px 30px rgba(0,0,0,.25);
}

h2{
    text-align:center;
    color:#18335c;
    margin-bottom:10px;
}

.subtitulo{
    text-align:center;
    color:#666;
    margin-bottom:20px;
}

label{
    display:block;
    margin-top:12px;
    margin-bottom:5px;
    font-weight:bold;
    color:#18335c;
}

input{

    width:100%;

    padding:12px;

    border:1px solid #ccc;

    border-radius:10px;

    outline:none;
}

input:focus{
    border:2px solid #4da6ff;
}

.boton{

    width:100%;

    margin-top:20px;

    padding:12px;

    border:none;

    border-radius:10px;

    background:#4da6ff;

    color:white;

    font-size:16px;

    cursor:pointer;
}

.boton:hover{
    background:#2f5d9f;
}

label.error{
    color:red;
    font-size:12px;
    margin-top:5px;
}

input.error{
    border:2px solid red;
}

input.valid{
    border:2px solid green;
}

</style>

</head>

<body>

<div class="formulario">

<h2>✏️ Actualizar Usuario</h2>

<p class="subtitulo">
Modifique los datos del usuario
</p>

<form id="formulario" action="updateusuario2.php" method="POST">

     <label>CI</label>
     <input type="number"name="ci"id="ci"value="<?php echo $ci; ?>"readonly>

     <label>Nombre</label>
     <input type="text"name="nombre"id="nombre"value="<?php echo $nombre; ?>">

     <label>Dirección</label>
     <input type="text"name="direccion"id="direccion"value="<?php echo $direccionUsuario; ?>">

     <label>Celular</label>
     <input type="number"name="celular"id="celular"value="<?php echo $celular; ?>">

     <label>Rol</label>
     <input type="text"name="rol"id="rol"value="<?php echo $rol; ?>">

     <label>Estado</label>
     <input type="text"name="estado"id="estado"value="<?php echo $estado; ?>">

     <button type="submit" class="boton">
Guardar Cambios
</button>

</form>

</div>

<script>

$(document).ready(function(){

$("#formulario").validate({

rules:{

nombre:{
required:true
},

direccion:{
required:true
},

celular:{
required:true
},

rol:{
required:true
},

estado:{
required:true
}

},

messages:{

nombre:{
required:"Ingrese el nombre"
},

direccion:{
required:"Ingrese la dirección"
},

celular:{
required:"Ingrese el celular"
},

rol:{
required:"Ingrese el rol"
},

estado:{
required:"Ingrese el estado"
}

}

});

});

</script>

</body>
</html>