<?php
session_start();
$rutaMenu = "../";

$mensajes = [];

if(file_exists("../ejemplo.txt")){

    $lineas = file("../ejemplo.txt", FILE_IGNORE_NEW_LINES);

    for($i=0; $i<count($lineas); $i++){
        if($lineas[$i] == "ASUNTO:"){
            $asunto = isset($lineas[$i+1]) ? $lineas[$i+1] : "";
            $comentario = isset($lineas[$i+3]) ? $lineas[$i+3] : "";
            $mensajes[] = ["asunto"=>$asunto, "comentario"=>$comentario];
            $i += 3;
        }
    }
}

$mensajes = array_reverse($mensajes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mensajes Recibidos</title>

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
    align-items:flex-start;
}

.contenedor{
    max-width:1000px;
    width:100%;
    background:white;
    padding:30px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

h1{
    text-align:center;
    color:#18335c;
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
}

th{
    background:#4da6ff;
    color:white;
    padding:15px;
}

td{
    padding:12px;
    text-align:left;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f4f8ff;
}

.volver{
    display:block;
    width:250px;
    margin:30px auto 0;
    text-align:center;
    text-decoration:none;
    background:#18335c;
    color:white;
    padding:15px;
    border-radius:10px;
    font-weight:bold;
}

.volver:hover{
    background:#2f5d9f;
}

</style>
</head>
<body>

<?php include("../menu.php"); ?>

<main class="fondo-panel">
    <div class="contenedor">

        <h1>Mensajes Recibidos</h1>

        <table>
            <tr>
                <th>Asunto</th>
                <th>Comentario</th>
            </tr>

            <?php if(count($mensajes) > 0){ ?>

                <?php foreach($mensajes as $m){ ?>
                    <tr>
                        <td><?php echo htmlspecialchars($m['asunto']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($m['comentario'])); ?></td>
                    </tr>
                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="2">No hay mensajes registrados.</td>
                </tr>

            <?php } ?>

        </table>

        <a href="formulario.php" class="volver">Escribir un Mensaje</a>

    </div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>