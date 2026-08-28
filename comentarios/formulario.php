<?php
session_start();
$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dragon Ice | Buzón de Mensajes</title>
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
        .form-box textarea{
            width:100%;
            padding:12px;
            border:none;
            border-radius:10px;
            outline:none;
            background:rgba(255,255,255,0.15);
            color:white;
            font-size:15px;
            font-family:Arial, Helvetica, sans-serif;
        }

        .form-box textarea{
            resize:vertical;
            min-height:120px;
        }

        .form-box input::placeholder,
        .form-box textarea::placeholder{
            color:rgba(255,255,255,0.65);
        }

        .form-box input:focus,
        .form-box textarea:focus{
            background:rgba(255,255,255,0.25);
            box-shadow:0 0 0 2px var(--celeste);
        }

        .form-box input[type="submit"]{
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

        .form-box input[type="submit"]:hover{
            background:var(--menta);
            transform:scale(1.02);
        }

        .form-box .volver{
            display:block;
            margin-top:18px;
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
            <p class="subtitulo">Buzón de Mensajes</p>

            <form action="mensaje.php" method="POST">

                <label for="asunto">Asunto</label>
                <input type="text" id="asunto" name="asunto" placeholder="Ej: Pedido, Sugerencia, Consulta" required>

                <label for="come">Comentario</label>
                <textarea id="come" name="come" placeholder="Escribe aquí tu mensaje..." required></textarea>

                <input type="submit" value="Enviar Mensaje">
                

            </form>

            <a href="ver.php" class="volver">Ver todos los mensajes</a>
        </div>
    </main>
</section>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>