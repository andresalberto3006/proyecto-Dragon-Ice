<?php header("Location: ../formpedido.php"); exit(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <title>Compralo</title>

    <link rel="stylesheet" href="../">

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
<<<<<<< HEAD:formularios/05.formulariousuario.php
       body{
            overflow:auto;
        }
      section {
        position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
=======

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
>>>>>>> 38a9d61561d31fd892b063ad5593f2793a467338:carrito/formulariocarrito.php
        }

        video {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

<<<<<<< HEAD:formularios/05.formulariousuario.php
        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
        }

        main{
           position:absolute;
           inset:0;
           display:flex;
           justify-content:center;
           align-items:center;
           z-index:10;
           padding:20px;
        }

        .login-box{
            width:420px;
           max-width:95%;
           max-height:90vh;
           overflow-y:auto;
           padding:30px;
           background:rgba(0,0,0,.55);
           backdrop-filter:blur(12px);
           border-radius:20px;
           border:1px solid rgba(255,255,255,.2);
           box-shadow:0 0 30px rgba(0,191,255,.4);
        }

        .login-box h2 {
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

       .login-box label{
           display:block;
           text-align:left;
           color:white;
           margin-top:10px;
           margin-bottom:3px;
           font-size:15px;
           font-weight:bold;
        }

        .login-box input[type="text"],
        .login-box input[type="number"],
        .login-box input[type="password"] {
            width: 100%;
=======
            margin-top: 15px;
>>>>>>> 38a9d61561d31fd892b063ad5593f2793a467338:carrito/formulariocarrito.php
            padding: 12px;
            border: none;
            border-radius: 10px;
<<<<<<< HEAD:formularios/05.formulariousuario.php
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            color: white;
=======

            background-color: #4da6ff;

            color: white;

>>>>>>> 38a9d61561d31fd892b063ad5593f2793a467338:carrito/formulariocarrito.php
            font-size: 16px;
        }

<<<<<<< HEAD:formularios/05.formulariousuario.php
        label.error{
            color:#ff8080;
            font-size:12px;
            margin-top:3px;
            margin-bottom:5px;
            display:block;
        }

input.error{
    border:2px solid #ff5555;
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

        @media(max-width:700px){

    body{
        overflow:auto;
    }

        .login-box{
           width:95%;
           padding:20px;
        max-height:95vh;
        }

        .login-box h2{
           font-size:30px;
        }

        .login-box input{
           font-size:14px;
        }

      }

      
    
=======
>>>>>>> 38a9d61561d31fd892b063ad5593f2793a467338:carrito/formulariocarrito.php
    </style>
</head>

<body>
<<<<<<< HEAD:formularios/05.formulariousuario.php
    <section>

        <video autoplay muted loop>
            <source src="download.mp4" type="video/mp4">
        </video>

        <div class="overlay"></div>

<main>
    <div class="login-box">
        <h2>Crear Cuenta</h2>
=======

    <div class="formulario">

        <h2>🍦 Registrar tu compra</h2>

>>>>>>> 38a9d61561d31fd892b063ad5593f2793a467338:carrito/formulariocarrito.php
        <p class="subtitulo">
            Complete los datos de la compra
        </p>

        <form action="../crud/registrocarrito.php" method="POST">

<<<<<<< HEAD:formularios/05.formulariousuario.php
            <label for="ci">CI</label>
            <input type="number" name="ci">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre">

            <label for="direccion">Direccion:</label>
            <input type="text" name="direccion">

            <label for="celular">Celular:</label>
            <input type="number" name="celular">

            <label for="rol">Rol:</label>
            <input type="text" name="rol">

            <label for="estado">Estado:</label>
            <input type="text" name="estado">

          <input type="submit"value="Crear Cuenta">
=======
            <div class="grupo">

                <label for="ci">Código / CI</label>
                <input type="number" id="ci" name="ci" placeholder="Ingrese el código">
                <label for="id_productos">Código del producto</label>
                <input type="number" id="id_productos" name="id_productos" placeholder="Ingrese el código">

            </div>

            <div class="grupo">
                <label for="id_pedidos">Numero del pedido</label>
                <input type="text" id="id_pedidos" name="id_pedidos" placeholder="Ingrese el número del pedido">
            </div>

            <div class="grupo">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" placeholder="Ingrese la cantidad">
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

                <label for="costotal">Costo total</label>
                <input type="number" id="costotal" name="costotal" placeholder="Ingrese el costo total">
            </div>

            <button type="submit" class="boton">
                Registrar compra
            </button>

>>>>>>> 38a9d61561d31fd892b063ad5593f2793a467338:carrito/formulariocarrito.php
        </form>
        
    </div>
<<<<<<< HEAD:formularios/05.formulariousuario.php
</main>
        
    </section>
    


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
=======
>>>>>>> 38a9d61561d31fd892b063ad5593f2793a467338:carrito/formulariocarrito.php

</body>

</html>