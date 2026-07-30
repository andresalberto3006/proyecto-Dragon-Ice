<?php
session_start();
// Usamos isset() para evitar el warning "Undefined array key 'nombre'"
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Administrador';

// $rutaMenu le indica a menu.php cómo llegar a la raíz del proyecto desde esta carpeta (admin/)
$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel de Administración | TechZone</title>
<style>

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:Arial, Helvetica, sans-serif;
    }

    body{
        background:linear-gradient(180deg,#e8f2fb,#f5f9fd 40%);
        min-height:100vh;
    }

    a{ text-decoration:none; color:inherit; }

    /* ---------- CONTENIDO ---------- */

    .contenido{
        max-width:1200px;
        margin:0 auto;
        padding:30px 24px;
    }

    /* Tarjeta de bienvenida */

    .bienvenida{
        background:#ffffff;
        border-left:6px solid #29a8e0;
        border-radius:10px;
        padding:24px 30px;
        box-shadow:0 4px 14px rgba(0,0,0,0.08);
        margin-bottom:24px;
    }

    .bienvenida h1{
        color:#111a2e;
        font-size:28px;
        margin-bottom:12px;
    }

    .bienvenida p{
        color:#555;
        font-size:15px;
        line-height:1.6;
    }

    /* Cuadrícula de tarjetas */

    .tarjetas{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:22px;
    }

    .tarjeta{
        background:#ffffff;
        border-radius:10px;
        overflow:hidden;
        box-shadow:0 4px 14px rgba(0,0,0,0.08);
    }

    /* Antes las 2 primeras tarjetas tenían la franja negra (#111a2e) y las
       otras 2 celeste (.clara). Ahora todas usan el mismo color celeste
       para que las 4 se vean igual. */
    .tarjeta .franja{
        height:6px;
        background:#29a8e0;
    }

    .tarjeta .cuerpo{
        padding:26px 28px;
    }

    .tarjeta h2{
        color:#173a8a;
        font-size:20px;
        margin-bottom:12px;
    }

    .tarjeta p{
        color:#555;
        font-size:14.5px;
        line-height:1.6;
        margin-bottom:20px;
    }

    .boton{
        display:inline-block;
        background:#29a8e0;
        color:#0b1f33;
        font-weight:700;
        font-size:14.5px;
        padding:11px 22px;
        border-radius:8px;
        transition:.2s;
    }

    .boton:hover{
        background:#1c8fc4;
    }

    @media (max-width:760px){
        .tarjetas{ grid-template-columns:1fr; }
    }

</style>
</head>
<body>

<?php include("../menu.php"); ?>

<main class="contenido">

    <section class="bienvenida">
        <h1>Panel de administración</h1>
        <p>
            Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>.
            Desde aquí se controla la gestión general del sistema.
        </p>
    </section>

    <section class="tarjetas">

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Usuarios y vendedores</h2>
                <p>Permite registrar administradores y vendedores, editar sus datos, cambiar su estado y bloquear o desbloquear vendedores.</p>
                <a href="../usuario/read.all.usuario.php" class="boton">Gestionar usuarios</a>
            </div>
        </article>

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Ventas generales</h2>
                <p>Muestra todas las ventas registradas en el sistema. El administrador puede revisar, editar o eliminar ventas.</p>
                <a href="../ventas.php" class="boton">Ver ventas</a>
            </div>
        </article>

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Consulta de pedidos</h2>
                <p>Permite consultar el estado de un pedido utilizando el ID del pedido y el nombre del cliente externo.</p>
                <a href="../pedidos.php" class="boton">Consultar pedido</a>
            </div>
        </article>

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Catálogo </h2>
                <p>Muestra los productos disponibles con su información, stock, categoría e imagen registrada.</p>
                <a href="../producto/read.all.producto.php" class="boton">Ver catálogo</a>
            </div>
        </article>

    </section>

</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>