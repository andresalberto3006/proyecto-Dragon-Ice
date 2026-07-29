<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador') { header("Location: 04.vendedor.php"); exit(); }
include("../conexion.php");

$r1=$conexion->query("SELECT COUNT(*) AS total FROM usuario")->fetch_assoc();
$r2=$conexion->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc();
$r3=$conexion->query("SELECT IFNULL(SUM(total),0) AS total FROM ventas WHERE fecha=CURDATE()")->fetch_assoc();
$r4=$conexion->query("SELECT COUNT(*) AS total FROM pedidos")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel del Administrador | Dragon Ice</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>

    :root{
        --navy: #0d2445;
        --panel: #143261;
        --panel-light: #1c4079;
        --sky: #4da6ff;
        --sky-soft: #9fd0ff;
        --mint: #35d6a1;
        --mint-dark: #22b487;
        --text-light: #eaf3ff;
        --text-muted: #a9c1e0;
        --radius: 16px;
    }

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    body{
        font-family:'Inter', Arial, sans-serif;
        background:linear-gradient(160deg,var(--navy),#08152c 70%);
        color:var(--text-light);
        min-height:100vh;
    }

    h1,h2,h3{
        font-family:'Baloo 2', 'Inter', sans-serif;
    }

    a{
        text-decoration:none;
        color:inherit;
    }

    /* ---------- ESTRUCTURA GENERAL ---------- */

    .app-shell{
        display:flex;
        flex-direction:column;
        min-height:100vh;
    }

    .layout{
        display:flex;
        flex:1;
    }

    /* ---------- BARRA SUPERIOR ---------- */

    .topbar{
        display:flex;
        align-items:center;
        justify-content:center;
        padding:22px 28px;
        background:var(--panel);
        border-bottom:1px solid rgba(255,255,255,0.08);
    }

    .topbar-titulo{
        font-size:26px;
        font-weight:700;
        color:var(--sky-soft);
        letter-spacing:.5px;
    }

    /* ---------- BARRA LATERAL (menú) ---------- */

    .sidebar{
        width:250px;
        flex-shrink:0;
        background:var(--panel);
        border-right:1px solid rgba(255,255,255,0.08);
        padding:24px 16px;
        display:flex;
        flex-direction:column;
        gap:10px;
    }

    .sidebar .seccion-nombre{
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:1px;
        color:var(--text-muted);
        padding:8px 12px 4px;
    }

    .nav-item{
        display:block;
        padding:15px 16px;
        border-radius:12px;
        font-size:15px;
        font-weight:600;
        color:var(--text-light);
        background:var(--panel-light);
        border:1px solid rgba(255,255,255,0.08);
        transition:.2s;
        text-align:left;
    }

    .nav-item:hover{
        background:var(--sky);
        color:var(--navy);
        transform:translateX(3px);
    }

    /* ---------- CONTENIDO PRINCIPAL ---------- */

    .content{
        flex:1;
        padding:32px;
        display:flex;
        flex-direction:column;
        gap:28px;
    }

    /* Tarjetas de estadísticas: solo lectura, no son enlaces */

    .stats{
        display:grid;
        grid-template-columns:repeat(4, 1fr);
        gap:22px;
    }

    .stat-card{
        background:var(--panel);
        border:1px solid rgba(255,255,255,0.07);
        border-radius:var(--radius);
        padding:34px 26px;
        display:flex;
        flex-direction:column;
        gap:10px;
        cursor:default;
    }

    .stat-card .etiqueta{
        font-size:16px;
        color:var(--text-muted);
        font-weight:600;
    }

    .stat-card .valor{
        font-size:38px;
        font-weight:700;
        font-family:'Baloo 2', sans-serif;
    }

    /* Cuadrícula de paneles inferiores */

    .paneles{
        display:grid;
        grid-template-columns: 1.3fr 1.3fr 1fr;
        gap:20px;
        align-items:stretch;
    }

    .card{
        background:var(--panel);
        border:1px solid rgba(255,255,255,0.07);
        border-radius:var(--radius);
        padding:22px;
        display:flex;
        flex-direction:column;
        gap:16px;
    }

    .card h2{
        font-size:17px;
        color:var(--sky-soft);
    }

    /* Gráfico de barras simple con CSS */

    .grafico-barras{
        flex:1;
        display:flex;
        align-items:flex-end;
        justify-content:space-around;
        gap:14px;
        min-height:150px;
        padding:0 6px;
    }

    .barra-grupo{
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:8px;
        flex:1;
    }

    .barra{
        width:100%;
        max-width:36px;
        border-radius:8px 8px 0 0;
        background:linear-gradient(180deg,var(--sky),#2c5da3);
    }

    .barra-grupo span{
        font-size:12px;
        color:var(--text-muted);
    }

    /* Gráfico circular con conic-gradient */

    .grafico-torta-wrap{
        display:flex;
        align-items:center;
        gap:20px;
        flex:1;
    }

    .grafico-torta{
        width:130px;
        height:130px;
        border-radius:50%;
        flex-shrink:0;
        background:conic-gradient(
            var(--sky) 0% 50%,
            var(--mint) 50% 75%,
            var(--sky-soft) 75% 90%,
            #274b7f 90% 100%
        );
    }

    .leyenda{
        display:flex;
        flex-direction:column;
        gap:10px;
        font-size:13px;
    }

    .leyenda li{
        display:flex;
        align-items:center;
        gap:8px;
        list-style:none;
    }

    .leyenda .punto{
        width:11px;
        height:11px;
        border-radius:50%;
        flex-shrink:0;
    }

    /* Accesos rápidos */

    .accesos{
        display:flex;
        flex-direction:column;
        gap:12px;
    }

    .btn-acceso{
        background:var(--mint);
        color:#04241a;
        font-weight:700;
        font-size:14px;
        padding:13px 16px;
        border-radius:12px;
        transition:.2s;
        text-align:center;
    }

    .btn-acceso:hover{
        background:var(--mint-dark);
        transform:translateY(-2px);
    }

    /* ---------- PIE DE PÁGINA ---------- */

    footer{
        text-align:center;
        padding:16px;
        font-size:12px;
        color:var(--text-muted);
        border-top:1px solid rgba(255,255,255,0.08);
        background:var(--panel);
    }

    @media (max-width:1100px){
        .paneles{ grid-template-columns:1fr 1fr; }
        .stats{ grid-template-columns:repeat(2,1fr); }
    }

    @media (max-width:760px){
        .layout{ flex-direction:column; }
        .sidebar{ width:100%; flex-direction:row; flex-wrap:wrap; }
        .paneles{ grid-template-columns:1fr; }
        .stats{ grid-template-columns:1fr 1fr; }
    }

</style>
</head>
<body>

<div class="app-shell">

    <header class="topbar">
        <div class="topbar-titulo">Panel de Administrador</div>
    </header>

    <div class="layout">

        <aside class="sidebar">
            <p class="seccion-nombre">Menú</p>
            <a href="../usuario/read.all.usuario.php" class="nav-item">Gestionar usuario</a>
            <a href="../producto/read.all.producto.php" class="nav-item">Gestionar Productos</a>
            <a href="../ventas.php" class="nav-item">Visualizar ventas</a>
            <a href="../pedidos.php" class="nav-item">Supervisar ventas y pedidos</a>
        </aside>

        <main class="content">

            <!-- Tarjetas de resumen: solo para ver, no son botones -->
            <section class="stats">
                <div class="stat-card">
                    <span class="etiqueta">Total de usuarios</span>
                    <span class="valor"><?php echo $r1['total']; ?></span>
                </div>
                <div class="stat-card">
                    <span class="etiqueta">Total de productos</span>
                    <span class="valor"><?php echo $r2['total']; ?></span>
                </div>
                <div class="stat-card">
                    <span class="etiqueta">Ventas</span>
                    <span class="valor">Bs. <?php echo number_format($r3['total'], 2); ?></span>
                </div>
                <div class="stat-card">
                    <span class="etiqueta">Pedidos totales</span>
                    <span class="valor"><?php echo $r4['total']; ?></span>
                </div>
            </section>

            <!-- Paneles: gráficos y accesos rápidos -->
            <section class="paneles">

                

                <article class="card">
                    <h2>Ventas por categoría</h2>
                    <div class="grafico-torta-wrap">
                        <div class="grafico-torta"></div>
                        <ul class="leyenda">
                            <li><span class="punto" style="background:var(--sky);"></span> Helados clásicos — 50%</li>
                            <li><span class="punto" style="background:var(--mint);"></span> Helados rellenos — 25%</li>
                            <li><span class="punto" style="background:var(--sky-soft);"></span> Línea saludable — 15%</li>
                            <li><span class="punto" style="background:#274b7f;"></span> Otros — 10%</li>
                        </ul>
                    </div>
                </article>

                <article class="card">
                    <h2>Accesos rápidos</h2>
                    <div class="accesos">
                        <a href="../usuario/formulariousuario.php" class="btn-acceso">Crear usuario</a>
                        <a href="../producto/formularioproducto.php" class="btn-acceso">Registrar producto</a>
                        <a href="../ventas.php" class="btn-acceso">Ver todas las ventas</a>
                        <a href="../pedidos.php" class="btn-acceso">Ver pedidos</a>
                    </div>
                </article>

            </section>

        </main>

    </div>

    <footer>
        Dragon Ice &copy; <?php echo date("Y"); ?> — Sistema de Control de Inventario y Punto de Venta
    </footer>

</div>

</body>
</html>
