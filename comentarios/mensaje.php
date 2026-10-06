<?php
session_start();
$rutaMenu = "../";

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: formulario.php");
    exit();
}

$asu = trim(str_replace(array("\r", "\n"), " ", $_POST["asunto"]));
$come = trim(str_replace(array("\r", "\n"), " ", $_POST["come"]));

$archivo = fopen("./ejemplo.txt","w");
fwrite($archivo, "ASUNTO:".PHP_EOL);
fwrite($archivo, $asu.PHP_EOL);
fwrite($archivo, "COMENTARIO:".PHP_EOL);
fwrite($archivo, $come.PHP_EOL);
fclose($archivo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mensaje Enviado | Dragon Ice</title>

<style>

:root{
    --azul-oscuro:#0e2a4d;
    --celeste:#63d4f2;
    --menta:#7be0c4;
    --gris-texto:#5b7590;
}

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
    padding:40px 20px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.tarjeta{
    width:100%;
    max-width:480px;
    background:white;
    padding:45px 35px;
    border-radius:25px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.25);
}

.icono{
    width:90px;
    height:90px;
    margin:0 auto 22px;
    border-radius:50%;
    background:var(--menta);
    display:flex;
    align-items:center;
    justify-content:center;
}

.icono svg{
    width:46px;
    height:46px;
    stroke:var(--azul-oscuro);
    fill:none;
    stroke-width:3;
    stroke-linecap:round;
    stroke-linejoin:round;
}

h1{
    color:var(--azul-oscuro);
    font-size:28px;
    margin-bottom:12px;
}

p{
    font-size:16px;
    line-height:1.6;
    color:var(--gris-texto);
    margin-bottom:28px;
}

.botones{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.boton{
    display:block;
    text-decoration:none;
    padding:14px 25px;
    border-radius:12px;
    font-weight:bold;
    font-size:15px;
    transition:.25s;
}

.boton.principal{
    background:var(--azul-oscuro);
    color:white;
}

.boton.principal:hover{
    background:var(--celeste);
    color:var(--azul-oscuro);
}

.boton.secundario{
    background:white;
    color:var(--azul-oscuro);
    border:2px solid var(--celeste);
}

.boton.secundario:hover{
    background:var(--menta);
    border-color:var(--menta);
}

</style>
</head>
<body>

<?php include("../paginaprincipal/menu.php"); ?>

<main class="fondo-panel">
    <div class="tarjeta">

        <div class="icono">
            <svg viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"></path></svg>
        </div>

        <h1>¡Mensaje enviado!</h1>

        <p>Gracias por escribirnos, tu mensaje fue registrado correctamente.</p>

        <div class="botones">
            <a href="ver.php" class="boton principal">Ver todos los mensajes</a>
            <a href="formulario.php" class="boton secundario">Escribir otro mensaje</a>
        </div>

    </div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>