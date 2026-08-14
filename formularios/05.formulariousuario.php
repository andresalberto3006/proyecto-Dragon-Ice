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
            font-family: Arial, Helvetica, sans-serif;
        }
       body{
            overflow:auto;
        }
      section {
        position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        video {
            position: absolute;
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
            padding: 12px;
            border: none;
            border-radius: 10px;
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 16px;
        }

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
        <h2>Crear Cuenta</h2>
        <p class="subtitulo">
            Complete los datos del usuario
        </p>

        
        <form id="formulario" action="../crud/registrousuario.php" method="POST">

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
        </form>
    </div>
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

</body>

</html>