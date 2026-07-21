<?php
session_start();if(!isset($_SESSION['rol'])){header("Location: iniciosesion.php");exit();}if($_SESSION['rol']!='Administrador'){header("Location: paginaprincipal/04.vendedor.php");exit();}include("conexion.php");$id=isset($_GET['id'])?$_GET['id']:0;$r=$conexion->query("SELECT * FROM ventas WHERE id='$id'");if($r->num_rows==0){header("Location: ventas.php");exit();}$v=$r->fetch_assoc();?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Actualizar Venta</title>
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
<body><div class="formulario"><h2>✏️ Actualizar Venta</h2><p class="subtitulo">Modifique los datos permitidos</p><form action="actualizarVenta.php" method="POST"><input type="hidden" name="id" value="<?php echo $v['id'];?>"><label>Cliente</label><input type="text" name="cliente" value="<?php echo $v['cliente'];?>"><label>Fecha</label><input type="date" name="fecha" value="<?php echo $v['fecha'];?>"><label>Método de pago</label><input type="text" name="metodo_pago" value="<?php echo $v['metodo_pago'];?>"><button type="submit" class="boton">Guardar Cambios</button></form></div></body></html>