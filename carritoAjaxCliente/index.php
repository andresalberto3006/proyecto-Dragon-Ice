<?php

session_start();

$rutaMenu = "../";

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dragon Ice - Productos</title>

<!-- ==========================================
     MENU DE DRAGON ICE
     ========================================== -->

<?php include("../menu.php"); ?>


<style>

/* =====================================================
   DRAGON ICE - ESTILOS DEL CARRITO AJAX
   ===================================================== */

:root{

    --azul:#0e2a4d;
    --azul2:#123b63;
    --celeste:#63d4f2;
    --menta:#7be0c4;
    --blanco:#ffffff;
    --fondo:#eaf8ff;
    --texto:#557080;

}


/* =========================
   GENERAL
========================= */

body{

    margin:0;

    font-family:'Inter', Arial, sans-serif;

    background:
    linear-gradient(
        135deg,
        #eaf8ff,
        #d8f3ff,
        #ffffff
    );

    color:#16415c;

}


/* =========================
   CONTENIDO
========================= */

.contenido{

    width:92%;

    max-width:1200px;

    margin:auto;

    padding:40px 0 70px;

}


/* =========================
   TITULO
========================= */

.titulo{

    text-align:center;

    color:var(--azul);

    font-family:'Baloo 2', cursive;

    font-size:42px;

    margin-bottom:5px;

}


.subtitulo{

    text-align:center;

    color:var(--texto);

    margin-bottom:30px;

}


/* =========================
   BOTON NUEVO PEDIDO
========================= */

.contenedorAcciones{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:15px;

    margin-bottom:30px;

    flex-wrap:wrap;

}


.btnPrincipal{

    border:none;

    padding:13px 25px;

    border-radius:25px;

    background:var(--azul);

    color:white;

    font-weight:bold;

    cursor:pointer;

    transition:.2s;

}


.btnPrincipal:hover{

    background:var(--azul2);

    transform:translateY(-2px);

}


.btnConsultar{

    text-decoration:none;

    padding:13px 25px;

    border-radius:25px;

    background:var(--celeste);

    color:#0b1f22;

    font-weight:bold;

}


.btnConsultar:hover{

    background:var(--menta);

}


/* =========================
   PRODUCTOS
========================= */

#productos{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(230px,1fr));

    gap:25px;

}


/* =========================
   TARJETA
========================= */

.tarjeta{

    background:white;

    border-radius:20px;

    padding:18px;

    text-align:center;

    box-shadow:
    0 8px 25px
    rgba(14,42,77,.12);

    border:1px solid #d4effb;

    transition:.25s;

}


.tarjeta:hover{

    transform:translateY(-6px);

    box-shadow:
    0 14px 30px
    rgba(14,42,77,.20);

}


/* =========================
   IMAGEN PRODUCTO
========================= */

.tarjeta img{

    width:100%;

    height:210px;

    object-fit:cover;

    border-radius:15px;

    display:block;

    margin:auto;

}


.tarjeta h3{

    color:var(--azul);

    font-family:'Baloo 2', cursive;

    font-size:23px;

    margin:12px 0 5px;

}


.tarjeta p{

    color:var(--texto);

    min-height:45px;

}


.tarjeta h2{

    color:#159bd2;

}


/* =========================
   AGREGAR
========================= */

.btnAgregar{

    width:100%;

    border:none;

    padding:12px;

    border-radius:12px;

    background:var(--azul);

    color:white;

    font-weight:bold;

    cursor:pointer;

}


.btnAgregar:hover{

    background:var(--azul2);

}


.btnAgregar:disabled{

    opacity:.45;

    cursor:not-allowed;

}


/* =====================================================
   BOTON CARRITO
===================================================== */

.botonCarrito{

    position:fixed;

    right:25px;

    bottom:25px;

    z-index:900;

    width:60px;

    height:60px;

    border:none;

    border-radius:50%;

    background:var(--celeste);

    color:#0b1f22;

    font-size:25px;

    cursor:pointer;

    box-shadow:
    0 7px 20px
    rgba(0,0,0,.25);

}


.botonCarrito:hover{

    background:var(--menta);

    transform:scale(1.05);

}


/* =====================================================
   FONDO CARRITO
===================================================== */

#fondo{

    display:none;

    position:fixed;

    inset:0;

    z-index:998;

    background:
    rgba(5,25,35,.55);

    backdrop-filter:blur(3px);

}


#fondo.activo{

    display:block;

}


/* =====================================================
   SIDEBAR
===================================================== */

#sidebar{

    position:fixed;

    top:0;

    right:-450px;

    width:420px;

    max-width:90%;

    height:100vh;

    z-index:999;

    background:white;

    padding:25px;

    overflow-y:auto;

    box-shadow:
    -10px 0 30px
    rgba(0,0,0,.25);

    transition:.3s;

}


#sidebar.activo{

    right:0;

}


#sidebar h2{

    color:var(--azul);

    font-family:'Baloo 2', cursive;

    font-size:30px;

}


#cerrarCarrito{

    float:right;

    border:none;

    width:35px;

    height:35px;

    border-radius:50%;

    background:#eaf8ff;

    color:var(--azul);

    cursor:pointer;

}


/* =========================
   PRODUCTO CARRITO
========================= */

.productoCarrito{

    margin:15px 0;

    padding:15px;

    background:#eefaff;

    border:1px solid #ccecf8;

    border-radius:15px;

}


.productoCarrito img{

    width:80px;

    height:80px;

    object-fit:cover;

    border-radius:10px;

    float:left;

    margin-right:12px;

}


.productoCarrito::after{

    content:"";

    display:block;

    clear:both;

}


#totalCarrito{

    padding:15px;

    border-radius:12px;

    background:#dff8ef;

    color:#0b1f22;

}


/* =========================
   BOTONES CARRITO
========================= */

#vaciarCarrito,
#comprar{

    width:100%;

    padding:12px;

    margin-top:10px;

    border:none;

    border-radius:12px;

    color:white;

    font-weight:bold;

    cursor:pointer;

}


#vaciarCarrito{

    background:#1b4a52;

}


#comprar{

    background:var(--azul);

}


/* =====================================================
   MODAL PEDIDO
===================================================== */

#modalCompra{

    position:fixed;

    inset:0;

    z-index:1001;

    display:none;

    align-items:center;

    justify-content:center;

    background:
    rgba(5,25,35,.60);

    backdrop-filter:blur(4px);

}


#formularioPedido{

    width:450px;

    max-width:90%;

    background:white;

    padding:30px;

    border-radius:20px;

    box-shadow:
    0 15px 45px
    rgba(0,0,0,.25);

}


#formularioPedido h2{

    text-align:center;

    color:var(--azul);

    font-family:'Baloo 2', cursive;

}


#formularioPedido label{

    display:block;

    margin-top:10px;

    color:var(--azul);

    font-weight:bold;

}


#formularioPedido input,
#formularioPedido select{

    width:100%;

    padding:12px;

    margin-top:5px;

    border:1px solid #c9eaf7;

    border-radius:10px;

    outline:none;

}


#formularioPedido input:focus,
#formularioPedido select:focus{

    border-color:var(--celeste);

    box-shadow:
    0 0 0 3px
    rgba(99,212,242,.15);

}


#confirmarPedido,
#cancelarCompra{

    width:100%;

    border:none;

    padding:12px;

    margin-top:15px;

    border-radius:12px;

    font-weight:bold;

    cursor:pointer;

}


#confirmarPedido{

    background:var(--azul);

    color:white;

}


#cancelarCompra{

    background:#e7f6fb;

    color:var(--azul);

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:600px){

    .titulo{

        font-size:32px;

    }

    #productos{

        grid-template-columns:1fr;

    }

    #sidebar{

        width:90%;

    }

}

</style>

</head>


<body>


<!-- =====================================================
     CONTENIDO
===================================================== -->

<main class="contenido">


<h1 class="titulo">

Dragon Ice 🍦

</h1>


<p class="subtitulo">

Elige tus sabores favoritos y disfruta de nuestros helados.

</p>


<div class="contenedorAcciones">


<button
id="generarPedido"
class="btnPrincipal">

🛒 Generar nuevo pedido

</button>


<a
href="consultar_pedido.php"
class="btnConsultar">

Consultar pedido

</a>


</div>


<!-- PRODUCTOS -->

<div id="productos">

    <!-- productos.js los cargará aquí -->

</div>


</main>



<!-- =====================================================
     BOTON CARRITO
===================================================== -->

<button
id="carritoIcono"
class="botonCarrito"
title="Abrir carrito">

🛒

<span id="cantidadCarrito">

0

</span>

</button>



<!-- =====================================================
     FONDO
===================================================== -->

<div id="fondo"></div>



<!-- =====================================================
     CARRITO LATERAL
===================================================== -->

<div id="sidebar">


<button id="cerrarCarrito">

✕

</button>


<h2>

Mi carrito 🛒

</h2>


<div id="contenidoCarrito">

</div>


<h3 id="totalCarrito">

Total: Bs 0.00

</h3>


<button id="vaciarCarrito">

Vaciar carrito

</button>


<button id="comprar">

Comprar

</button>


</div>



<!-- =====================================================
     MODAL NUEVO PEDIDO
===================================================== -->

<div
id="modalCompra">


<div id="formularioPedido">


<h2>

Nuevo pedido

</h2>


<label>

Nombre:

</label>


<input
type="text"
id="nombre"
placeholder="Tu nombre">


<label>

Teléfono:

</label>


<input
type="text"
id="telefono"
placeholder="Tu teléfono">


<label>

Dirección:

</label>


<input
type="text"
id="direccion"
placeholder="Tu dirección">


<label>

Método de pago:

</label>


<select id="metodoPago">

<option value="">

Seleccionar método

</option>

<option value="Efectivo">

Efectivo

</option>

<option value="QR">

QR

</option>

</select>


<button
id="confirmarPedido">

Confirmar pedido

</button>


<button
id="cancelarCompra">

Cancelar

</button>


</div>


</div>



<!-- =====================================================
     PIE DE PAGINA
===================================================== -->

<?php

include("../paginaprincipal/piedepagina.php");

?>



<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script src="js/productos.js"></script>

<script src="js/carrito.js"></script>

<script src="js/pedido.js"></script>


</body>

</html>