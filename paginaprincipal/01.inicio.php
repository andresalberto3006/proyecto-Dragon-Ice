<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dragon Ice</title>
    <link rel="stylesheet" href="user.css">
</head>

<body>
    
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
                    <img src="../imagenesproyecto/logo.png" alt="Logo">
                    <h1>Dragon Ice</h1>
                </a>
            </aside>
            <nav>
                <a href="01.inicio.php">Inicio</a>
                <article>
                    <a href="./formularios/formulariousuario.php">
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
