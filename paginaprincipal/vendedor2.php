<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel del Vendedor · Heladería Glaciar</title>

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
    height: 78px;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.marca{
    display:flex;
    align-items:center;
    gap:12px;
}
.marca .cono{
    font-size: 34px;
    line-height: 1;
}
.marca h1{
    font-size: 20px;
    letter-spacing: 0.3px;
}
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
    flex: 0 0 220px;
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
    font-size: 15px;
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
}
nav .stat{
    flex:1;
    background: var(--azul-panel);
    border: 1px solid var(--azul-borde);
    border-radius: var(--radio);
    padding: 16px;
    text-align: left;
    transition: 0.25s;
}
nav .stat:hover{
    transform: translateY(-3px);
    border-color: var(--azul-cielo);
}
nav .stat .icono{ font-size: 22px; }
nav .stat .etiqueta{
    font-size: 12.5px;
    color: var(--texto-suave);
    margin-top: 6px;
}
nav .stat .valor{
    font-size: 21px;
    font-weight: 700;
    margin-top: 2px;
    color: var(--azul-celeste);
}

section{
    display:flex;
    gap: 18px;
    flex: 1;
    align-items: stretch;
}

.tarjeta{
    background: var(--azul-panel);
    border: 1px solid var(--azul-borde);
    border-radius: var(--radio);
    padding: 20px;
}
.tarjeta h2{
    font-size: 16px;
    color: var(--azul-celeste);
    margin-bottom: 14px;
    display:flex;
    align-items:center;
    gap:8px;
}

/* Formulario */
#ttt{
    flex: 0 0 280px;
    display:flex;
    flex-direction:column;
}
form{
    display:flex;
    flex-direction:column;
    gap: 12px;
    flex:1;
}
label{
    font-size: 12.5px;
    color: var(--texto-suave);
    margin-bottom: -6px;
}
input{
    padding: 11px 12px;
    border: 1px solid var(--azul-borde);
    border-radius: 10px;
    background: rgba(255,255,255,0.95);
    color: black;
    font-size: 14px;
}
input:focus{
    outline: 2px solid var(--azul-cielo);
}
form button{
    margin-top: 8px;
    height: 48px;
    border-radius: 12px;
    border: none;
    background: var(--menta);
    color: #063a33;
    font-size: 15px;
    font-weight: 700;
    cursor:pointer;
    transition: 0.25s;
}
form button:hover{
    background:#7cf3df;
    transform: scale(1.02);
}

/* Tablas */
.col-tablas{
    flex: 1;
    display:flex;
    gap: 18px;
    min-width: 0;
}
.tarjeta.tabla{
    flex:1;
    display:flex;
    flex-direction:column;
    min-width: 0;
}
.tabla-scroll{
    flex:1;
    overflow:auto;
    border-radius: 12px;
}
table{
    width:100%;
    border-collapse: collapse;
    background: white;
    color: #0d2447;
    font-size: 13.5px;
}
thead th{
    background: var(--azul-cielo);
    color: #06263f;
    padding: 10px;
    position: sticky;
    top:0;
}
tbody td{
    padding: 9px 10px;
    border-bottom: 1px solid #e3f2fb;
    text-align:center;
}
tbody tr:nth-child(even){
    background: #f2fbff;
}
tbody tr:hover{
    background: var(--azul-celeste);
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
    nav{ flex-wrap: wrap; }
    nav .stat{ flex: 1 1 45%; }
    section{ flex-direction: column; }
    .col-tablas{ flex-direction: column; }
    header{ flex-wrap: wrap; height:auto; padding: 16px; gap: 10px; }
}
</style>
</head>
<body>
<?php session_start(); ?>

<header>
    <div class="marca">
        <span class="cono">🍦</span>
        <h1>Heladería Glaciar
            <span>Sistema de ventas</span>
        </h1>
    </div>
    <div class="panel-titulo">Panel del Vendedor</div>
    <button id="crack">Cerrar sesión</button>
</header>

<main>

    <aside>
        <button class="activo">🧾 Ventas</button>
        <button>🍨 Productos</button>
        <button>📦 Pedidos</button>
        <button>🕓 Historial</button>
    </aside>

    <article>
        <nav>
            <div class="stat">
                <div class="icono">💰</div>
                <div class="etiqueta">Ventas del día</div>
                <div class="valor">$170.000</div>
            </div>
            <div class="stat">
                <div class="icono">📦</div>
                <div class="etiqueta">Productos disponibles</div>
                <div class="valor">120</div>
            </div>
            <div class="stat">
                <div class="icono">⏳</div>
                <div class="etiqueta">Pedidos pendientes</div>
                <div class="valor">15</div>
            </div>
            <div class="stat">
                <div class="icono">🔄</div>
                <div class="etiqueta">Pedidos en proceso</div>
                <div class="valor">10</div>
            </div>
        </nav>

        <section>
            <div class="tarjeta" id="ttt">
                <h2>🛒 Ordena aquí</h2>
                <form>
                    <label for="cliente">Cliente</label>
                    <input id="cliente" type="text" placeholder="Seleccionar cliente">

                    <label for="producto">Producto</label>
                    <input id="producto" type="text" placeholder="Seleccionar producto">

                    <label for="cantidad">Cantidad</label>
                    <input id="cantidad" type="number" min="1" placeholder="Cantidad">

                    <label for="total">Total</label>
                    <input id="total" type="text" placeholder="$0.00">

                    <button type="submit">🛒 Guardar venta</button>
                </form>
            </div>

            <div class="col-tablas">
                <div class="tarjeta tabla">
                    <h2>📜 Historial de ventas</h2>
                    <div class="tabla-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>#0001</td><td>$5</td><td>18/05/2026</td></tr>
                                <tr><td>#0002</td><td>$5</td><td>18/05/2026</td></tr>
                                <tr><td>#0003</td><td>$4</td><td>18/05/2026</td></tr>
                                <tr><td>#0004</td><td>$7</td><td>18/05/2026</td></tr>
                                <tr><td>#0005</td><td>$5</td><td>18/05/2026</td></tr>
                                <tr><td>#0006</td><td>$5</td><td>18/05/2026</td></tr>
                                <tr><td>#0007</td><td>$7</td><td>18/05/2026</td></tr>
                                <tr><td>#0008</td><td>$10</td><td>18/05/2026</td></tr>
                                <tr><td>#0009</td><td>$6</td><td>18/05/2026</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tarjeta tabla">
                    <h2>🍨 Stock de productos</h2>
                    <div class="tabla-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Helado de café</td><td>4</td></tr>
                                <tr><td>Helado de canela</td><td>1</td></tr>
                                <tr><td>Helado de frutilla</td><td>2</td></tr>
                                <tr><td>Banana split</td><td>4</td></tr>
                                <tr><td>Helado de durazno</td><td>1</td></tr>
                                <tr><td>Helado de leche</td><td>2</td></tr>
                                <tr><td>Helado de chocolate</td><td>3</td></tr>
                                <tr><td>Helado de vainilla</td><td>2</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </article>

</main>

<footer style="margin-top:18px; text-align:center; padding:14px; background:var(--azul-panel); border:1px solid var(--azul-borde); color:var(--texto-suave); font-size:12.5px;">
    Heladería Glaciar &copy; 2026 · Panel del Vendedor
</footer>

</body>
</html>