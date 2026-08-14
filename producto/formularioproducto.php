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
        :root{
            --azul-oscuro:#0e2a4d;
            --celeste:#63d4f2;
            --menta:#7be0c4;
            --texto-suave:#d9f6ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-section{
            position:relative;
            width:100%;
            min-height:100vh;
            overflow:hidden;
        }

        .auth-section video{
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            width:100%;
            height:100%;
            object-fit:cover;
            z-index:0;
        }

        .auth-section .overlay{
            position:absolute;
            inset:0;
            background:rgba(14,42,77,0.55);
            z-index:1;
        }

        .auth-section main{
            position:relative;
            z-index:2;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:40px 20px;
        }

        .form-box{
            width:100%;
            max-width:430px;
            padding:40px;
            background:rgba(0,0,0,0.55);
            backdrop-filter:blur(12px);
            border-radius:20px;
            border:1px solid rgba(255,255,255,0.2);
            box-shadow:0 0 30px rgba(99,212,242,0.35);
            text-align:center;
        }

        .form-box h1{
            color:white;
            font-size:34px;
            letter-spacing:3px;
            margin-bottom:8px;
            text-shadow:0 0 15px var(--celeste);
        }

        .form-box .subtitulo{
            color:var(--texto-suave);
            margin-bottom:25px;
            font-size:15px;
        }

        .form-box form{
            text-align:left;
        }

        .form-box label{
            display:block;
            text-align:left;
            color:white;
            margin-bottom:5px;
            margin-top:15px;
            font-weight:bold;
            font-size:14px;
        }

        .form-box input,
        .form-box select{
            width:100%;
            padding:12px;
            border:none;
            border-radius:10px;
            outline:none;
            background:rgba(255,255,255,0.15);
            color:white;
            font-size:15px;
        }

        .form-box input::placeholder{
            color:rgba(255,255,255,0.65);
        }

        .form-box input:focus,
        .form-box select:focus{
            background:rgba(255,255,255,0.25);
            box-shadow:0 0 0 2px var(--celeste);
        }

        .form-box input[type="submit"],
        .form-box button[type="submit"]{
            width:100%;
            margin-top:22px;
            padding:13px;
            border:none;
            border-radius:10px;
            background:var(--celeste);
            color:var(--azul-oscuro);
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .form-box input[type="submit"]:hover,
        .form-box button[type="submit"]:hover{
            background:var(--menta);
            transform:scale(1.02);
        }

        .form-box input[type="submit"]:disabled{
            opacity:.6;
            cursor:not-allowed;
        }

        .form-box .enlace-secundario{
            margin-top:18px;
            font-size:14px;
            color:var(--texto-suave);
            text-align:center;
        }

        .form-box .enlace-secundario a{
            color:var(--celeste);
            font-weight:bold;
            text-decoration:none;
        }

        .form-box .enlace-secundario a:hover{
            text-decoration:underline;
            color:var(--menta);
        }

        .form-box .volver{
            display:block;
            margin-top:10px;
            color:white;
            font-size:13px;
            opacity:0.8;
            text-decoration:none;
            text-align:center;
        }

        .form-box .volver:hover{
            opacity:1;
            color:var(--celeste);
        }

        .form-box label.error{
            color:#ff9b9b;
            font-size:12px;
            margin-top:4px;
            margin-bottom:0;
            font-weight:bold;
        }

        .form-box input.error{
            box-shadow:0 0 0 2px #ff4d4d;
        }

        .form-box input.valid{
            box-shadow:0 0 0 2px var(--menta);
        }

        @media(max-width:700px){
            .form-box{ padding:28px; }
            .form-box h1{ font-size:26px; }
        }
    </style>
</head>

<body>

<?php include("../menu.php"); ?>

<section class="auth-section">
    <video autoplay muted loop>
        <source src="../helado1.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>
    <main>
        <div class="form-box">
            <h1>DRAGON ICE</h1>
            <p class="subtitulo">Registrar Producto</p>

            <form id="formulario" action="../producto/registroproducto.php" method="POST" enctype="multipart/form-data">

                <label for="id">ID</label>
                <input type="number" id="id" name="id" placeholder="Ingrese el código">

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre">

                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" placeholder="Descripción del producto">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Ingrese el precio">

                <label for="costo">Costo</label>
                <input type="number" id="costo" name="costo" placeholder="Ingrese el costo">

                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" placeholder="Cantidad disponible">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen">

                <input type="submit" value="Guardar Producto">
            </form>

            <a href="read.all.producto.php" class="volver">Volver a la lista de productos</a>
        </div>
    </main>
</section>

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
                },
                submitHandler: function(form){

                    const boton = $(form).find("input[type=submit]");
                    const textoOriginal = boton.val();

                    boton.prop("disabled", true).val("Guardando...");

                    const datos = new FormData(form);

                    fetch("../producto/registroproducto.php", {
                        method: "POST",
                        body: datos
                    })
                    .then(response => response.json())
                    .then(data => {

                        if(data.ok){
                            window.location.href = "read.all.producto.php";
                        }else{
                            alert(data.mensaje || "No se pudo registrar el producto");
                            boton.prop("disabled", false).val(textoOriginal);
                        }

                    })
                    .catch(error => {
                        console.log(error);
                        alert("Ocurrió un error al registrar el producto");
                        boton.prop("disabled", false).val(textoOriginal);
                    });

                }
            });
        });
    </script>
</body>
</html>