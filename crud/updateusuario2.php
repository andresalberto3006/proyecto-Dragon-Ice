<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Hubo un error al conectar la base de datos");
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $ci = $_POST['ci'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    $sql = "UPDATE usuario
            SET nombre='$nombre',
                direccion='$direccion',
                celular='$celular',
                rol='$rol',
                estado='$estado'
            WHERE ci='$ci'";

    if($conn->query($sql)===TRUE){
        ?>

        <!DOCTYPE html>
        <html lang="es">
        <head>
        <meta charset="UTF-8">
        <title>Usuario Actualizado</title>

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

        .mensaje{

            width:500px;

            background:white;

            padding:40px;

            border-radius:25px;

            text-align:center;

            box-shadow:0 10px 30px rgba(0,0,0,.25);
        }

        h1{
            color:#28a745;
            margin-bottom:20px;
        }

        p{
            font-size:18px;
            color:#444;
            margin-bottom:25px;
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

        <div class="mensaje">

            <h1>✅ Usuario actualizado correctamente</h1>

            <p>
                Los cambios fueron guardados exitosamente.
            </p>

            <a href="read.all.usuario.php" class="boton">
                Ver todos los usuarios
            </a>

        </div>

        </body>
        </html>

        <?php

    }else{

        echo "Error: ".$conn->error;

    }

}

?>