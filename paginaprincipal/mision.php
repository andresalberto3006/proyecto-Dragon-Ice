<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}
        body{
            display: grid;
            grid-template-rows: 100vh 150px;
            grid-template-columns: 100%;
            grid-template-areas:
            "tres tres"
            "cua cua";
        }
        section h1{
            background-color: rgba(0, 154, 236, 0.571);
            height: 50px;
            border-radius: 10px;
            margin: 20px;
        }
        section p{
            background-color: rgba(81, 154, 200, 0.571);
            height: auto;
            border-radius: 10px;
            margin: 20px;
        }
        section{
           color:white;
            background:linear-gradient(rgb(3, 3, 52),rgb(4, 40, 87),rgba(8, 78, 190, 0.568));
            grid-area: tres;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        footer{
            background-color: rgba(0, 154, 236, 0.571);
            grid-area: cua;
        }
    </style>
</head>
<body>
     <header> 
        <?php
        $rutaMenu="../"; include("../menu.php");
        ?>
    </header>
    <section>
        <h1>MISIÓN</h1>
        <p>Nuestra misión es elaborar y promover estos helados naturales y accesibles, impulsando el desarrollo local en Bolivia, apoyando y generando empleo a productores bolivianos, desarrollo industrial e impulso a la economía local generando hábitos de alimentación saludables, brindando un momento de unión en familia o con amigos. </p>
    </section>
    <footer>
        <p> 2023 Mi Sitio Web. Todos los derechos reservados.</p>
    </footer>
</body>
</html>