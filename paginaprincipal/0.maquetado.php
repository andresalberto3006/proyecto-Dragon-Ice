<?php
header("Location: 01.inicio.php");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        header{
        background-color: #0c2657;
        grid-area: uno;
        .header{
           
        background-color: rgba(12, 121, 172, 0.548);
         padding-left: 20px;
         padding-right: 50px;
        }

    }
    img{
        position: absolute;
        top: 16px;
        left: 20px;
        width: 182px;
        height: 182px;
        border-radius: 70%;
        border: 3px solid black;
        }
    /*.logo{
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
            height: 80px;
            border-radius: 70%;
            border: 3px solid black;
        }
            */
        nav{
        background-color: rgb(67, 120, 180);
            grid-area: dos;
            border-radius: 9px;
        }
        section{
            background-color: #0c2657;
            grid-area: tres;
        }
        footer{
            background-color: #83ccf7;
            height: 300px;
            grid-area: cua;
        }
        .map iframe{
            height: 295px;
            position: absolute;
            right: 20px;
            border: 0;

        }
        body{
            display: grid;
            grid-template-rows: 100px 800px 100px;
            grid-template-columns:20% 80%;
            background-color: #03071b;
            grid-template-areas:
            "dos uno"
            "dos tres"
            "cua cua";
            gap: 5px;
        }
        @media(max-width:700px){
            nav{

            }
            footer{
                background-color: rgba(0, 119, 255, 0.356);
            }
            section{
            }
            body{
                  grid-template-columns: 25% 25% 25% 25%;
                  grid-template-areas:
                "dos dos"
               "uno uno"
            "tres tres"
            "cua cua";
            gap: 5px;
            }
           
        }
    /*   <img src="xd.png" class="logo" alt="">*/
    </style>
</head>
<body>
    <header>
        <a href="" target="_blank" rel="noopener noreferrer"><img src="./imagenesproyecto.logo.png" alt=""></a>
        <h2 class="dragon">Dragon Ice </h2>
        <a href="" class="a">Inicio</a>
        <a href="" class="b">Sobre Nosotros</a>
        <a href="" class="c">Contacto</a>
    </header>
    <nav></nav>
    <section></section>
    <footer class="map">
    </footer>

</body>
</html>
