<?php
header("Location: 02.admin.php");
exit();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel del Administrador · Heladería Glaciar</title>

<style>
:root{
    --azul-noche: #071228;
    --azul-panel: #0d2447;
    --azul-borde: #1e4d7b;
    --azul-cielo: #38bdf8;
    --azul-celeste: #a8e6ff;
    --menta: #5eead4;
    --rojo: #f87171;
    --blanco: #f4fbff;
    --texto-suave: #b9d4ec;
    --radio: 18px;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Inter", Arial, sans-serif;
}

body{
    background:
        radial-gradient(circle at 15% 10%, rgba(56,189,248,0.10), transparent 40%),
        radial-gradient(circle at 85% 90%, rgba(94,234,212,0.08), transparent 40%),
        var(--azul-noche);
    color: var(--blanco);
    padding: 20px;
    min-height: 100vh;
}

h1, h2, h3{
    font-family:"Baloo 2", "Inter", sans-serif;
    font-weight: 600;
}

header, nav, article, section, aside, footer{
    border-radius: var(--radio);
}

/* ---------- HEADER ---------- */
header{
    background: linear-gradient(120deg, var(--azul-panel), #123a63);
    border: 1px solid var(--azul-borde);
    min-height: 78px;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}
.marca{
    display:flex;
    align-items:center;
    gap:12px;
    padding: 14px 0;
}
.marca .cono{ font-size: 34px; line-height: 1; }
.marca h1{ font-size: 20px; letter-spacing: 0.3px; }
.marca span{
    display:block;
    font-size: 12px;
    color: var(--texto-suave);
    font-weight:400;
    font-family:"Inter", sans-serif;
}
header .panel-titulo{
    font-size: 15px;
    color: var(--azul-celeste);
    font-family:"Inter", sans-serif;
    font-weight: 600;
}
#crack{
    background: var(--rojo);
    color: white;
    border: none;
    border-radius: 12px;
    height: 42px;
    padding: 0 18px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.25s;
}
#crack a{
    color:white;
    text-decoration:none;
}
#crack:hover{
    transform: scale(1.05);
    background:#ef4444;
}

/* ---------- MAIN LAYOUT ---------- */
main{
    display:flex;
    gap: 18px;
    margin-top: 18px;
}

/* ---------- ASIDE ---------- */
aside{
    background: linear-gradient(160deg, #123a63, #0a2647);
    border: 1px solid var(--azul-borde);
    flex: 0 0 240px;
    padding: 24px 16px;
    display:flex;
    flex-direction: column;
    gap: 14px;
}
aside button{
    background: rgba(255,255,255,0.06);
    border: 1px solid var(--azul-borde);
    color: var(--blanco);
    height: 54px;
    border-radius: 14px;
    font-size: 14.5px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.25s;
    text-align: left;
    padding: 0 18px;
}
aside button.activo,
aside button:hover{
    background: var(--azul-cielo);
    color: var(--azul-noche);
    transform: translateX(4px);
}

/* ---------- ARTICLE ---------- */
article{
    flex: 1;
    display:flex;
    flex-direction: column;
    gap: 18px;
    min-width: 0;
}

nav{
    display:flex;
    gap: 14px;
    flex-wrap: wrap;
}
nav .stat{
    flex:1;
    min-width: 160px;
    background: var(--azul-panel);
    border: 1px solid var(--azul-borde);
    border-radius: var(--radio);
    padding: 16px;
    transition: 0.25s;
}
nav .stat:hover{
    transform: translateY(-3px);
    border-color: var(--azul-cielo);
}
nav .stat .etiqueta{
    font-size: 12.5px;
    color: var(--texto-suave);
}
nav .stat .valor{
    font-size: 22px;
    font-weight: 700;
    margin-top: 4px;
    color: var(--azul-celeste);
}

section{
    display:flex;
    gap: 18px;
    flex-wrap: wrap;
}

.tarjeta{
    background: var(--azul-panel);
    border: 1px solid var(--azul-borde);
    border-radius: var(--radio);
    padding: 20px;
    flex: 1;
    min-width: 280px;
    transition: 0.3s;
}
.tarjeta:hover{
    transform: translateY(-3px);
    border-color: var(--azul-cielo);
}
.tarjeta h2{
    font-size: 16px;
    color: var(--azul-celeste);
    margin-bottom: 14px;
}

/* Gráficos hechos en CSS/SVG, sin imágenes externas */
.grafico-barras{
    display:flex;
    align-items:flex-end;
    gap: 10px;
    height: 160px;
    padding: 10px 4px 0;
}
.grafico-barras .barra{
    flex:1;
    background: linear-gradient(180deg, var(--azul-cielo), #1d6fa5);
    border-radius: 8px 8px 0 0;
    position: relative;
}
.grafico-barras .barra span{
    position:absolute;
    top:-20px;
    left:0;
    right:0;
    text-align:center;
    font-size: 11px;
    color: var(--texto-suave);
}
.grafico-barras .mes{
    font-size: 11px;
    color: var(--texto-suave);
    text-align:center;
}
.eje-x{
    display:flex;
    gap:10px;
    margin-top: 6px;
}
.eje-x div{ flex:1; text-align:center; font-size:11px; color:var(--texto-suave); }

.dona-wrap{
    display:flex;
    align-items:center;
    gap: 18px;
    flex-wrap: wrap;
    justify-content:center;
}
.leyenda{
    display:flex;
    flex-direction:column;
    gap: 8px;
    font-size: 13px;
}
.leyenda .item{ display:flex; align-items:center; gap:8px; color: var(--texto-suave); }
.leyenda .punto{ width:11px; height:11px; border-radius:50%; display:inline-block; }

.accesos{
    display:flex;
    flex-direction:column;
    gap: 12px;
}
.accesos a{
    background: rgba(255,255,255,0.06);
    border: 1px solid var(--azul-borde);
    border-radius: 12px;
    padding: 12px 16px;
    color: var(--blanco);
    text-decoration:none;
    font-weight: 600;
    font-size: 14px;
    transition: 0.25s;
    display:flex;
    align-items:center;
    gap: 10px;
}
.accesos a:hover{
    background: var(--menta);
    color: #063a33;
    transform: scale(1.02);
    border-color: var(--menta);
}

footer{
    margin-top: 18px;
    text-align:center;
    padding:14px;
    background: var(--azul-panel);
    border: 1px solid var(--azul-borde);
    color: var(--texto-suave);
    font-size: 12.5px;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 900px){
    main{ flex-direction: column; }
    aside{
        flex-direction: row;
        flex-wrap: wrap;
        flex: none;
        width: 100%;
    }
    aside button{ flex: 1 1 45%; text-align:center; }
    section{ flex-direction: column; }
    header{ padding: 16px; }
}
</style>
</head>
<body>
<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
$apellidoUsuario = isset($_SESSION['apellido']) ? $_SESSION['apellido'] : '';
?>

<header>
    <div class="marca">
        <span class="cono">🍦</span>
        <h1>Heladería Glaciar
            <span>Sistema de administración</span>
        </h1>
    </div>
    <div class="panel-titulo">Panel del Administrador</div>
    <button id="crack">
        <a href="iniciosesion.php">Cerrar sesión <?php echo htmlspecialchars($nombreUsuario . ' ' . $apellidoUsuario); ?></a>
    </button>
</header>

<main>

    <aside>
        <button class="activo">👤 Gestionar usuarios</button>
        <button>🍨 Gestionar productos</button>
        <button>📊 Visualizar reportes</button>
        <button>🧾 Supervisar ventas y pedidos</button>
    </aside>

    <article>
        <nav>
            <div class="stat">
                <div class="etiqueta">Total de usuarios</div>
                <div class="valor">48</div>
            </div>
            <div class="stat">
                <div class="etiqueta">Total de productos</div>
                <div class="valor">120</div>
            </div>
            <div class="stat">
                <div class="etiqueta">Ventas del día</div>
                <div class="valor">$170.000</div>
            </div>
            <div class="stat">
                <div class="etiqueta">Pedidos totales</div>
                <div class="valor">25</div>
            </div>
        </nav>

        <section>
            <div class="tarjeta">
                <h2>📈 Resumen de ventas</h2>
                <div class="grafico-barras">
                    <div class="barra" style="height:55%"><span>$120k</span></div>
                    <div class="barra" style="height:70%"><span>$150k</span></div>
                    <div class="barra" style="height:60%"><span>$130k</span></div>
                    <div class="barra" style="height:90%"><span>$170k</span></div>
                    <div class="barra" style="height:80%"><span>$160k</span></div>
                </div>
                <div class="eje-x">
                    <div>Lun</div><div>Mar</div><div>Mié</div><div>Jue</div><div>Vie</div>
                </div>
            </div>

            <div class="tarjeta">
                <h2>🥧 Ventas por categoría</h2>
                <div class="dona-wrap">
                    <svg width="130" height="130" viewBox="0 0 42 42">
                        <circle cx="21" cy="21" r="15.9" fill="transparent" stroke="#123a63" stroke-width="6"></circle>
                        <circle cx="21" cy="21" r="15.9" fill="transparent" stroke="#38bdf8" stroke-width="6"
                            stroke-dasharray="40 60" stroke-dashoffset="25" transform="rotate(-90 21 21)"></circle>
                        <circle cx="21" cy="21" r="15.9" fill="transparent" stroke="#5eead4" stroke-width="6"
                            stroke-dasharray="30 70" stroke-dashoffset="-15" transform="rotate(-90 21 21)"></circle>
                        <circle cx="21" cy="21" r="15.9" fill="transparent" stroke="#a8e6ff" stroke-width="6"
                            stroke-dasharray="30 70" stroke-dashoffset="-45" transform="rotate(-90 21 21)"></circle>
                    </svg>
                    <div class="leyenda">
                        <div class="item"><span class="punto" style="background:#38bdf8"></span> Helados clásicos · 40%</div>
                        <div class="item"><span class="punto" style="background:#5eead4"></span> Postres especiales · 30%</div>
                        <div class="item"><span class="punto" style="background:#a8e6ff"></span> Bebidas frías · 30%</div>
                    </div>
                </div>
            </div>

            <div class="tarjeta">
                <h2>⚡ Accesos rápidos</h2>
                <div class="accesos">
                    <a href="crear_usuario.php">👤 Crear usuario</a>
                    <a href="registrar_producto.php">🍨 Registrar producto</a>
                    <a href="ventas.php">🧾 Ver todas las ventas</a>
                    <a href="reportes.php">📄 Generar reporte</a>
                </div>
            </div>
        </section>
    </article>

</main>

<footer>
    Heladería Glaciar &copy; 2026 · Panel del Administrador
</footer>

</body>
</html>