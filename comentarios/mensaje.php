<?php
session_start();
$rutaMenu = "../";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $asu = $_POST["asunto"];
    $come = $_POST["come"];

    $archivo = fopen("../ejemplo.txt","a");
    fwrite($archivo, "ASUNTO:".PHP_EOL);
    fwrite($archivo, $asu.PHP_EOL);
    fwrite($archivo, "COMENTARIO:".PHP_EOL);
    fwrite($archivo, $come.PHP_EOL);
    fclose($archivo);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mensaje Enviado</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

html, body{
    height:100%;
}

body{
    display:flex;
    flex-direction:column;
    min-height:100vh;
}

.fondo-panel{
    flex:1;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:40px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.tarjeta{
    width:500px;
    background:white;
    padding:40px;
    border-radius:25px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.25);
}

.icono{
    font-size:80px;
    margin-bottom:20px;
}

.exito{
    color:#28a745;
}

p{
    font-size:16px;
    color:#555;
    margin-bottom:25px;
}

.boton{
    text-decoration:none;
    background:#4da6ff;
    color:white;
    padding:12px 25px;
    border-radius:10px;
    font-weight:bold;
    transition:.3s;
}

.boton:hover{
    background:#2f5d9f;
}

</style>
</head>
<body>

<?php include("../menu.php"); ?>

<main class="fondo-panel">
    <div class="tarjeta">

        <div class="icono"></div>

        <h1 class="exito">Mensaje enviado correctamente</h1>

        <p>Gracias por escribirnos, tu mensaje fue registrado.</p>

        <a href="ver.php" class="boton">Ver todos los mensajes</a>

    </div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>