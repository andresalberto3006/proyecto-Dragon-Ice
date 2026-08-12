<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: ../paginaprincipal/vendedor20.php"); exit(); }
include("../conexion.php");

$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <title>Registrar Usuario</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
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

        .formulario{
            width:380px;
            padding:35px;
            border-radius:25px;
            background:white;
            box-shadow:0 10px 30px rgba(0,0,0,.25);
        }

        h2{
            text-align: center;
            color: #18335c;
            margin-bottom: 10px;
        }

        .subtitulo{
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }

        label{
            display: block;
            margin-top: 12px;
            margin-bottom: 5px;
            font-weight:bold;
            color: #18335c;
            font-size: 15px;
        }

        input{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        input:focus{
            border: 2px solid #4da6ff;
        }

        .boton{
            width: 100%;
            background-color: #4da6ff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .boton:hover{
            background-color: #2f5d9f;
        }

        label.error{
            color: red;
            font-size: 12px;
            margin-top: 5px;
            font-weight: bold;
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

<?php include("../menu.php"); ?>

<main class="fondo-panel">
    <div class="formulario">
        <h2> Registrar Usuario</h2>
        <p class="subtitulo">
            Complete los datos del usuario
        </p>

        <form id="formulario" action="../usuario/registrousuario.php" method="POST">

            <label for="ci">CI</label>
            <input type="number" id="ci" name="ci">

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre">

            <label for="direccion">Direccion:</label>
            <input type="text"id="direccion"  name="direccion">

            <label for="celular">Celular:</label>
            <input type="number" id="celular" name="celular">

            <label for="rol">Rol:</label>
            <input type="text" id="rol" name="rol">

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado">

            <button type="submit" class="boton">
            Crear Cuenta
            </button>
        </form>
    </div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>
    
    <script>
$(document).ready(function(){

$("#formulario").validate({

rules:{
    ci:{
        required:true
    },
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
    ci:{
        required:"Ingrese su ci"
    },
    nombre:{
        required:"Ingrese su nombre"
    },
    direccion:{
        required:"Ingrese su direccion"
    },
    celular:{
        required:"Ingrese su celular"
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