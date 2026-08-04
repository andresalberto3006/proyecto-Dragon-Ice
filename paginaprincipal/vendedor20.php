<?php
session_start();
// Usamos isset() para evitar el warning "Undefined array key 'nombre'"
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Vendedor';

// $rutaMenu le indica a menu.php cómo llegar a la raíz del proyecto desde esta carpeta (admin/)
$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel de Administración |</title>
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

    .bienvenido{
        background:#ffffff;
        border-left:6px solid #29a8e0;
        border-radius:10px;
        padding:24px 30px;
        box-shadow:0 4px 14px rgba(0,0,0,0.08);
        margin-bottom:24px;
    }

    .bienvenido h1{
        color:#111a2e;
        font-size:28px;
        margin-bottom:12px;
    }

    .bienvenido p{
        color:#555;
        font-size:15px;
        line-height:1.6;
    }

    /* Cuadrícula de tarjetas */

    .tarjetas{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:30px;
    }

    .tarjeta{
        background:#ffffff;
        border-radius:10px;
        overflow:hidden;
        box-shadow:0 4px 14px rgba(0,0,0,0.08);
        min-height:325px;
        display:flex;
        flex-direction:column;
    }

    /* Antes las 2 primeras tarjetas tenían la franja negra (#111a2e) y las
       otras 2 celeste (.clara). Ahora todas usan el mismo color celeste
       para que las 4 se vean igual. */
    .tarjeta .franja{
        height:6px;
        background:#29a8e0;
    }

    .tarjeta .cuerpo{
        padding:42px 38px;
        display:flex;
        flex-direction:column;
        justify-content:center;
        flex:1;
    }

    .tarjeta h2{
        color:#173a8a;
        font-size:24px;
        margin-bottom:16px;
    }

    .tarjeta p{
        color:#555;
        font-size:16px;
        line-height:1.7;
        margin-bottom:26px;
    }

    .boton{
        display:inline-block;
        background:#29a8e0;
        color:#0b1f33;
        font-weight:700;
        font-size:15.5px;
        padding:13px 26px;
        border-radius:8px;
        transition:.2s;
        width:fit-content;
    }

    .boton:hover{
        background:#1c8fc4;
    }

    @media (max-width:760px){
        .tarjetas{ grid-template-columns:1fr; }
        .tarjeta{ min-height:auto; }
    }

</style>
</head>
<body>

<?php include("../menu.php"); ?>

<main class="contenido">

    <section class="bienvenido">
        <h1>Panel de Vendedor</h1>
        <p>
            Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>.
            Desde aquí puedes atender clientes y gestionar ventas.
        </p>
    </section>

    <section class="tarjetas">

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Productos</h2>
                <p>Registra nuevos accesorios tecnológicos, edita información, controla stock, agrega imágenes y organiza productos por categoría.</p>
                <a href="../producto/read.all.producto.php" class="boton">Gestionar Productos</a>
            </div>
        </article>

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Mis pedidos</h2>
                <p>Revisa los pedidos creados, consulta el detalle, cambia el estado y registra ventas desde pedidos aceptados.</p>
                <a href="../pedidos.php" class="boton">Ver Pedidos</a>
            </div>
        </article>

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Mis ventas</h2>
                <p>Consulta el historial de ventas que registraste, revisa comprobantes y accede al detalle de cada venta.</p>
                <a href="../ventas.php" class="boton">Mis Ventas</a>
            </div>
        </article>

        <article class="tarjeta">
            <div class="franja"></div>
            <div class="cuerpo">
                <h2>Nuevo Pedido</h2>
                <p>Crea un pedido para un cliente externo. Después podrás agregar productos al carrito y calcular el total.</p>
                <a href="../formpedido.php" class="boton">Ver Pedidos</a>
            </div>
        </article>

    </section>

</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>