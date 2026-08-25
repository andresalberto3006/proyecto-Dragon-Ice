<?php
session_start();
$rutaMenu = "../";
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Consultar Pedido - Dragon Ice</title>

<style>

:root{
    --azul-oscuro:#0e2a4d;
    --celeste:#63d4f2;
    --menta:#7be0c4;
    --texto-suave:#d9f6ff;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#ffffff;
    color:var(--azul-oscuro);
}


.contenido{
    width:92%;
    max-width:700px;
    margin:auto;
    padding:60px 0;
}


.tarjeta{
    background:white;
    padding:35px;
    border-radius:20px;
    border:1px solid #dcecf3;
    box-shadow:0 8px 25px rgba(14,42,77,.15);
}


.titulo{
    text-align:center;
    color:var(--azul-oscuro);
    font-size:30px;
    margin-bottom:10px;
}

.subtitulo{
    text-align:center;
    color:#5c7185;
    margin-bottom:30px;
}


label{
    display:block;
    margin-bottom:7px;
    color:var(--azul-oscuro);
    font-weight:bold;
}

input{
    width:100%;
    padding:12px;
    border:1px solid #c9e5ee;
    border-radius:9px;
    outline:none;
    margin-bottom:15px;
}

input:focus{
    border-color:var(--celeste);
    box-shadow:0 0 0 2px rgba(99,212,242,0.25);
}


#consultar{
    width:100%;
    padding:12px;
    border:none;
    border-radius:9px;
    background:var(--azul-oscuro);
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

#consultar:hover{
    background:var(--celeste);
    color:var(--azul-oscuro);
}


#resultado{
    margin-top:25px;
}

.resultado{
    background:#f2fbfe;
    border:1px solid #d6edf5;
    border-radius:14px;
    padding:20px;
}

.resultado h3{
    color:var(--azul-oscuro);
    margin-bottom:15px;
}

.dato{
    padding:10px 0;
    border-bottom:1px solid #d6edf5;
}

.dato:last-child{
    border-bottom:none;
}

.dato b{
    color:#5c7185;
}

.estado{
    color:var(--azul-oscuro);
    background:var(--menta);
    padding:2px 10px;
    border-radius:20px;
    font-weight:bold;
    font-size:14px;
}


.volver{
    display:block;
    width:220px;
    margin:25px auto 0;
    padding:12px;
    text-align:center;
    text-decoration:none;
    border-radius:9px;
    background:var(--celeste);
    color:var(--azul-oscuro);
    font-weight:bold;
    transition:.3s;
}

.volver:hover{
    background:var(--menta);
}


@media(max-width:500px){

    .contenido{
        padding:35px 0;
    }

    .tarjeta{
        padding:25px 20px;
    }

    .titulo{
        font-size:25px;
    }

}

</style>

</head>

<body>

<?php include("../menu.php"); ?>


<main class="contenido">

    <div class="tarjeta">

        <h1 class="titulo">
            Consultar Pedido
        </h1>

        <p class="subtitulo">
            Ingresa el número de tu pedido para consultar su estado.
        </p>


        <label>
            Número de pedido
        </label>

        <input
            type="number"
            id="numeroPedido"
            placeholder="Ejemplo: 1"
        >


        <button id="consultar">
            Consultar Estado
        </button>


        <div id="resultado"></div>


        <a href="index.php" class="volver">
            Volver a productos
        </a>

    </div>

</main>


<?php include("../paginaprincipal/piedepagina.php"); ?>


<script src="js/consultar.js"></script>

</body>

</html>