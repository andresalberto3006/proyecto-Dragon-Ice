<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>;
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>;
    <title>Formulario Heladería</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;

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

        .formulario {

            width: 330px;
            padding: 30px;

            border-radius: 15px;

            background-color: rgba(24, 45, 75, 0.9);

            border: 2px solid #6bb7ff;

            box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
        }

        .formulario h2 {
            text-align: center;
            color: #fff3d6;
            margin-bottom: 10px;
        }

        .subtitulo {
            text-align: center;
            color: #dcdcdc;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .grupo {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;

            color: #fff3d6;

            font-size: 15px;
        }

        input {
            width: 100%;

            padding: 10px;

            border-radius: 8px;
            border: none;

            background-color: #f2f2f2;

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
            background-color: #ffae42;
        }
    </style>
</head>

<body>

    <div class="formulario">

        <h2>🍦 Registrar Producto</h2>

        <p class="subtitulo">
            Complete los datos del producto
        </p>

        <form action="registro.php" method="POST">

            <div class="grupo">
                <label for="ci">Código / CI</label>
                <input type="text" id="ci" name="ci" placeholder="Ingrese el código">
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
                <input type="text" id="precio" name="precio" placeholder="Ingrese el precio">
            </div>

            <div class="grupo">
                <label for="costo">Costo</label>
                <input type="text" id="costo" name="costo" placeholder="Ingrese el costo">
            </div>

            <div class="grupo">
                <label for="stock">Stock</label>
                <input type="text" id="stock" name="stock" placeholder="Cantidad disponible">
            </div>

            <button type="submit" class="boton">
                Guardar Producto
            </button>

        </form>
        <a href="09.formadmin.html"></a>

    </div>

</body>

</html>