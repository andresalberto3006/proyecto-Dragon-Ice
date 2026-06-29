<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Error de conexión");
}

$id=$_GET['id'];

$sql="SELECT * FROM productos WHERE id='$id'";

$resultado=$conn->query($sql);

$fila=$resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<title>Editar Producto</title>

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

width:400px;

padding:30px;

background:white;

border-radius:20px;

box-shadow:0 10px 30px rgba(0,0,0,.25);

}

h2{
text-align:center;
margin-bottom:20px;
color:#18335c;
}

label{
display:block;
margin-top:12px;
margin-bottom:5px;
font-weight:bold;
}

input{
width:100%;
padding:10px;
border:1px solid #ccc;
border-radius:8px;
}

.boton{
width:100%;
margin-top:20px;
padding:12px;
border:none;
background:#4da6ff;
color:white;
font-size:16px;
border-radius:10px;
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

</style>
</head>

<body>

<div class="formulario">

<h2>✏️ Editar Producto</h2>

<form id="formulario" action="updateproducto2.php" method="POST">

<label>ID</label>
<input type="number"
name="id"
value="<?php echo $fila['id']; ?>"
readonly>

<label>Nombre</label>
<input type="text"
name="nombre"
value="<?php echo $fila['nombre']; ?>">

<label>Descripción</label>
<input type="text"
name="descripcion"
value="<?php echo $fila['descripcion']; ?>">

<label>Precio</label>
<input type="number"
name="precio"
value="<?php echo $fila['precio']; ?>">

<label>Costo</label>
<input type="number"
name="costo"
value="<?php echo $fila['costo']; ?>">

<label>Stock</label>
<input type="number"
name="stock"
value="<?php echo $fila['stock']; ?>">

<button type="submit" class="boton">
Actualizar Producto
</button>

</form>

</div>

<script>

$("#formulario").validate({

rules:{
nombre:{required:true},
descripcion:{required:true},
precio:{required:true},
costo:{required:true},
stock:{required:true}
},

messages:{
nombre:{required:"Ingrese el nombre"},
descripcion:{required:"Ingrese la descripción"},
precio:{required:"Ingrese el precio"},
costo:{required:"Ingrese el costo"},
stock:{required:"Ingrese el stock"}
}

});

</script>

</body>
</html>