<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dragon Ice - Iniciar Sesión</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            overflow: hidden;
        }

        section {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
        }

        main {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
        }

        .login-box {
            width: 400px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 30px rgba(0, 191, 255, 0.4);
        }

        .login-box h1 {
            color: white;
            font-size: 45px;
            letter-spacing: 5px;
            margin-bottom: 10px;
            text-shadow: 0 0 15px #00bfff;
        }

        .login-box p {
            color: #d9f6ff;
            margin-bottom: 25px;
        }

        .login-box label {
            display: block;
            text-align: left;
            color: white;
            margin-bottom: 5px;
            margin-top: 15px;
            font-weight: bold;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 16px;
        }

        .login-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login-box input[type="submit"] {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #00bfff;
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-box input[type="submit"]:hover {
            background: #0099cc;
            transform: scale(1.03);
            box-shadow: 0 0 20px #00bfff;
        }

        @media(max-width:700px) {
            .login-box {
                width: 90%;
                padding: 30px;
            }

            .login-box h1 {
                font-size: 35px;
            }
        }
    </style>
</head>

<body>

<section>
    <video autoplay muted loop>
        <source src="download.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>
    <main>
        <div class="login-box">
            <h1>DRAGON ICE</h1>
            <p>Iniciar Sesión</p>
            <form action="BDvali.php" method="post">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" placeholder="Ingrese su nombre" required>
                <label for="clave">Contraseña</label>
                <input type="text" name="clave" placeholder="Ingrese su numero de celular" required>
                <input type="submit" value="Ingresar">
            </form>
            <p style="margin-top:15px"><a href="paginaprincipal/01.inicio.php" style="color:white">Volver al inicio</a></p>
        </div>
    </main>
</section>

</body>

</html>