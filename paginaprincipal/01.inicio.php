<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dragon Ice</title>
    <link rel="stylesheet" href="user.css">
</head>

<body>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
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

        main {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 5;
        }

        main h1 {

            color: white;
            font-size: 80px;
            font-weight: bold;
            letter-spacing: 10px;
            text-shadow:
                0 0 15px rgba(0, 0, 0, 0.8),
                0 0 30px rgba(0, 0, 0, 0.7);
        }

        @media(max-width:700px) {

            header {
                height: auto;
                padding: 20px;
                flex-direction: column;
                gap: 15px;
            }

            nav {

                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            main h1 {
                font-size: 45px;
                text-align: center;
            }

        }
  </style>
    
<header class="menu-principal">

  <?php
  include("menu.php")
  
  ?>

</header>

    <section>
        <video autoplay muted loop muted>
            <source src="download.mp4" type="video/mp4">

        </video>
        <header>
            <aside>
                <a href="" class="logo">
                    <img src="../imagenes/logo.png" alt="Logo">
                    <h1>Dragon Ice</h1>
                </a>
            </aside>
            <nav>
                <a href="01.inicio.php">Inicio</a>
                <article>
                    <a href="./usuario/formulariousuario.php">
                    <button>prueba</button>
                    </a>
                    <ul>
                        <li>
                            <a href="02.admin.php">Administrador</a>
                            
                        </li>
                        <li>
                            <a href="04.vendedor.php">Vendedor</a>
                        </li>
                        <li>
                            <a href="03.usuario.php">Cliente</a>
                        </li>
                    </ul>
                </article>
                <a href="">Iniciar Sesión</a>
            </nav>
        </header>

        <main>
            <h1>DRAGON ICE</h1>
        </main>
        
    </section>
    <?php include("piedepagina.php"); ?>
</body>

</html>
