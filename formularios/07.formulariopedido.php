<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <title>Formulario Heladería</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
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

        .formulario{

            width: 330px;
            padding: 30px;

            border-radius: 15px;

            background-color: rgba(24, 45, 75, 0.9);

            border: 2px solid #6bb7ff;

            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }

        .formulario h2{
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

        .grupo{
            margin-bottom: 15px;
        }

        label{
            display: block;
            margin-bottom: 5px;

            color: #fff3d6;

            font-size: 15px;
        }

        input{
            width: 100%;

            padding: 10px;

            border-radius: 8px;
            border: none;

            background-color: #f2f2f2;

            outline: none;
        }

        input:focus{
            border: 2px solid #4da6ff;
        }

        .boton{

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

        .boton:hover{
            background-color: #ffae42;
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

    <div class="formulario">

        <h2>🍦 Registrar Pedido</h2>

        <p class="subtitulo">
            Complete los datos del producto
        </p>

        <form id= "formulario" action="../crud/registropedido.php" method="POST">

            <div class="grupo">
                <label for="id">Código</label>
                <input type="number" id="id" name="id" placeholder="Ingrese el código">
            </div>

            <div class="grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre">
            </div>

            <div class="grupo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" placeholder="Ingrese la fecha">
            </div>

            <div class="grupo">
                <label for="estado">Estado</label>
                <input type="text" id="estado" name="estado" placeholder="Ingrese el estado">
            </div>

            <div class="grupo">
                <label for="nombrevendedor">Nombre del Vendedor</label>
                <input type="text" id="nombrevendedor" name="nombrevendedor" placeholder="Ingrese el nombre del vendedor">
            </div>

            <button type="submit" class="boton">
                Registrar Pedido
            </button>

        </form>
        
    </div>

    <script>
$(document).ready(function(){

$("#formulario").validate({

rules:{
    id:{
        required:true
    },
    nombre:{
        required:true
    },
    fecha:{
        required:true
    },
    estado:{
        required:true
    },
    nombrevendedor:{
        required:true
    },
    
},

messages:{
    id:{
        required:"Ingrese su codigo/id"
    },
    nombre:{
        required:"Ingrese su nombre"
    },
    fecha:{
        required:"Ingrese la fecha"
    },
    estado:{
        required:"Ingrese su estado"
    },
    nombrevendedor:{
        required:"Ingrese el nombre del vendedor"
    },
    
}

});

});
</script>


</body>

</html>

