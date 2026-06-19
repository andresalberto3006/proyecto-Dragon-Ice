<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <title>Formulario Heladeria</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            font-family: Arial, sans-serif;

            background-image: url("music-musical-instrument-guitar-two-dark-background.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;

            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 100vh;
            padding: 20px;
        }

        .formulario{

            width: 330px;
            padding: 30px;

            border-radius: 15px;

            background-color: rgba(24, 45, 75, 0.9);

            border: 2px solid #6bb7ff;

            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }

        h2{
            text-align: center;
            color: #fff3d6;
            margin-bottom: 10px;
        }

        .subtitulo{
            text-align: center;
            color: #dcdcdc;
            margin-bottom: 20px;
            font-size: 14px;
        }

        label{
            display: block;

            margin-top: 12px;
            margin-bottom: 5px;

            color: #fff3d6;

            font-size: 15px;
        }

        input{
            width: 100%;

            padding: 10px;

            border: none;
            border-radius: 8px;

            background-color: #f2f2f2;

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
            background-color: #ffae42;
        }

    </style>
</head>

<body>
    <div class="formulario">
        <h2>Crear Cuenta</h2>
        <p class="subtitulo">
            Complete los datos del usuario
        </p>
        <form action="crud/registrousuario.php" method="POST">
            <label for="ci">CI</label>
            <input type="number" id="ci" name="ci">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre">
            <label for="direccion">Direccion:</label>
            <input type="text" id="direccion"name="direccion">

            <label for="celular">Celular:</label>
            <input type="number"id="celular" name="celular">

            <label for="rol">Rol:</label>
            <input type="text" id="rol"name="rol">

            <label for="estado">Estado:</label>
            <input type="text"id="estado" name="estado">

            <button type="submit" class="boton">
            Crear Cuenta
            </button>
        </form>
    </div>

</body>

</html>