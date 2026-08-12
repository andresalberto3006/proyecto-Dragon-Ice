<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'Vendedor') { header("Location: ../iniciosesion.php"); exit(); }
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
    <title>Registrar Producto</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        html, body{
            height:100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .fondo-panel{
            flex:1;
            background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
            padding:40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .formulario {
            width: 380px;
            padding: 30px;
            border-radius: 25px;
            background:white;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }

        .formulario h2 {
            text-align: center;
            color: #18335c;
            margin-bottom: 10px;
        }

        .subtitulo {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .grupo {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #18335c;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        input:focus {
            border: 2px solid #4da6ff;
        }

        .boton {
            width: 100%;
            margin-top: 15px;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background-color: #4da6ff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .boton:hover {
            background-color: #2f5d9f;
        }

        label.error {
            color: red;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }

        input.error {
            border: 2px solid red;
        }

        input.valid {
            border: 2px solid green;
        }
    </style>
</head>

<body>

<?php include("../menu.php"); ?>

<main class="fondo-panel">
    <div class="formulario">
        <h2> Registrar Producto</h2>
        <p class="subtitulo">Complete los datos del producto</p>

        <form id="formulario" action="../producto/registroproducto.php" method="POST" enctype="multipart/form-data">

            <div class="grupo">

                 <label for="id">id</label>
                 <input type="number" id ="id" name="id" placeholder="Ingrese el código"> 
               
            </div>

            <div class="grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre">
            </div>

            <div class="grupo">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" placeholder="Descripción del producto">
            </div>

            <div class="grupo">
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Ingrese el precio">
            </div>

            <div class="grupo">
                <label for="costo">Costo</label>
                <input type="number" id="costo" name="costo" placeholder="Ingrese el costo">
            </div>

            <div class="grupo">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" placeholder="Cantidad disponible">
            </div>

            <div class="grupo"><label for="imagen">Imagen</label><input type="file" id="imagen" name="imagen"></div>
            <button type="submit" class="boton">Guardar Producto</button>
        </form>
    </div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

    <script>
        $(document).ready(function(){
           $("#formulario").validate({
                rules:{
                    id:{ required:true },
                    nombre:{ required:true },
                    descripcion:{ required:true },
                    precio:{ required:true, number:true },
                    costo:{ required:true, number:true },
                    stock:{ required:true, number:true }
                },
                messages:{
                    id:{ required:"Ingrese el codigo del producto" },
                    nombre:{ required:"Ingrese el nombre del producto" },
                    descripcion:{ required:"Ingrese la descripción" },
                    precio:{ required:"Ingrese el precio" },
                    costo:{ required:"Ingrese el costo" },
                    stock:{ required:"Ingrese el stock disponible" }
                }
            });
        });
    </script>
</body>
</html>