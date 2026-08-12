<?php
session_start();

if(!isset($_SESSION["usuario"])){
    header("Location: iniciosesion.php");
    exit();
}

include("conexion.php");

$usuario=$_SESSION["usuario"];

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dragon Ice | Nuevo Pedido</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    min-height:100vh;

    background:linear-gradient(
        135deg,
        #18335c,
        #2f5d9f,
        #7fc7ff
    );

    background-attachment:fixed;
}

/* CONTENEDOR */

.contenedor{

    width:100%;
    min-height:calc(100vh - 80px);

    display:flex;
    justify-content:center;
    align-items:center;

    padding:50px 30px;
}

/* TARJETA DEL FORMULARIO */

.tarjeta{

    width:450px;

    background:white;

    border-radius:25px;

    padding:35px;

    box-shadow:0 15px 35px rgba(0,0,0,.25);

    border:1px solid rgba(255,255,255,.6);
}

/* TITULO */

.tarjeta h1{

    text-align:center;

    color:#18335c;

    margin-bottom:25px;

    font-size:28px;
}

/* ETIQUETAS */

label{

    display:block;

    margin-top:15px;

    margin-bottom:5px;

    font-weight:bold;

    color:#18335c;
}

/* CAMPOS */

input{

    width:100%;

    padding:12px;

    margin-top:2px;

    border:2px solid #d7eaff;

    background:#f4f9ff;

    border-radius:10px;

    font-size:16px;

    color:#18335c;

    outline:none;
}

input:focus{

    border-color:#4da6ff;

    background:white;
}

/* BOTÓN */

button{

    width:100%;

    padding:15px;

    margin-top:25px;

    border:none;

    background:#4da6ff;

    color:white;

    font-size:18px;

    font-weight:bold;

    cursor:pointer;

    border-radius:12px;

    transition:.3s;

    box-shadow:0 5px 12px rgba(77,166,255,.35);
}

button:hover{

    background:#2f5d9f;

    transform:scale(1.02);
}

</style>

</head>

<body>

<?php include("menu.php"); ?>


<div class="contenedor">

    <div class="tarjeta">

        <h1> Nuevo Pedido</h1>

        <form action="nuevo_pedido.php" method="POST">

            <label>Cliente</label>

            <input
                type="text"
                name="nombre"
                value="<?php echo $usuario;?>"
                readonly
            >

            <label>Fecha</label>

            <input
                type="date"
                name="fecha"
                value="<?php echo date("Y-m-d");?>"
                readonly
            >

            <input
                type="hidden"
                name="estado"
                value="En proceso"
            >

            <input
                type="hidden"
                name="nombrevendedor"
                value="<?php echo $usuario;?>"
            >

            <button>
                 Comenzar Compra
            </button>

        </form>

    </div>

</div>


<?php include("paginaprincipal/piedepagina.php"); ?>


</body>

</html>