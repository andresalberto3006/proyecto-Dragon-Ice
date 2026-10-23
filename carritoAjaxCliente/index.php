<?php
session_start();
$rutaMenu="../";
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Dragon Ice</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,Helvetica,sans-serif;
}

body{
    background:#fff;
    color:#0e2a4d;
}

.contenido{
    width:92%;
    max-width:1200px;
    margin:auto;
    padding:40px 0 90px;
}

.titulo{
    text-align:center;
    font-size:40px;
    margin-bottom:10px;
}

.subtitulo{
    text-align:center;
    color:#5c7185;
    margin-bottom:35px;
}

.acciones{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-bottom:35px;
    flex-wrap:wrap;
}

.btn-dragonice{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    width:220px;
    height:55px;
    border:0;
    border-radius:14px;
    background:#0e2a4d;
    color:white;
    font-family:Arial,Helvetica,sans-serif;
    font-size:15px;
    font-weight:bold;
    text-decoration:none;
    cursor:pointer;
    box-shadow:0 6px 16px rgba(14,42,77,.25);
    transition:.25s;
}

.btn-dragonice:hover{
    background:#63d4f2;
    color:#0e2a4d;
    box-shadow:0 8px 20px rgba(99,212,242,.35);
    transform:translateY(-2px);
}

.btn-dragonice.secundario{
    background:white;
    color:#0e2a4d;
    border:2px solid #63d4f2;
    box-shadow:0 6px 16px rgba(14,42,77,.1);
}

.btn-dragonice.secundario:hover{
    background:#7be0c4;
    border-color:#7be0c4;
    color:#0e2a4d;
}

/* ---------- PRODUCTOS ---------- */

#productos{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
    align-items:stretch;
}

.tarjeta{
    background:white;
    border:1px solid #dcecf3;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(14,42,77,.12);
    padding-bottom:15px;
    display:flex;
    flex-direction:column;
}

.tarjeta img{
    width:100%;
    height:260px;
    object-fit:cover;
    display:block;
}

.tarjeta .info{
    flex:1;
}

.tarjeta h3{
    margin:12px 15px 4px;
    font-size:18px;
}

.tarjeta p{
    margin:0 15px 6px;
    font-size:14px;
    line-height:1.3;
    color:#5c7185;
}

.tarjeta h2{
    margin:6px 15px 2px;
    font-size:28px;
    color:#159db9;
}

.tarjeta .stock{
    display:block;
    margin:0 15px;
    font-size:13px;
    color:#5c7185;
}

/* ---------- AGREGAR / AUMENTAR / DISMINUIR ---------- */

.zonaCompra{
    margin:12px 15px 0;
}

.btnAgregar{
    width:100%;
    padding:11px;
    border:0;
    border-radius:9px;
    background:#0e2a4d;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

.btnAgregar:hover{
    background:#173e63;
}

.btnAgregar:disabled{
    opacity:.5;
    cursor:not-allowed;
}

.selector{
    display:none;
    align-items:center;
    justify-content:space-between;
    background:#eaf8fc;
    border:1px solid #d6edf5;
    border-radius:9px;
    padding:4px;
}

.selector button{
    width:40px;
    height:36px;
    border:0;
    border-radius:7px;
    background:#0e2a4d;
    color:white;
    font-size:20px;
    font-weight:bold;
    cursor:pointer;
}

.selector button:hover{
    background:#173e63;
}

.selector button:disabled{
    opacity:.4;
    cursor:not-allowed;
}

.selector .cantidadProducto{
    font-size:18px;
    font-weight:bold;
    color:#0e2a4d;
}

.zonaCompra.conCantidad .btnAgregar{
    display:none;
}

.zonaCompra.conCantidad .selector{
    display:flex;
}

/* ---------- ICONO DEL CARRITO ---------- */

#carritoIcono{
    position:fixed;
    right:25px;
    bottom:25px;
    width:62px;
    height:62px;
    border:0;
    border-radius:50%;
    background:#63d4f2;
    color:#0e2a4d;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    box-shadow:0 5px 15px rgba(14,42,77,.3);
    transition:.25s;
    z-index:1000;
}

#carritoIcono svg{
    width:28px;
    height:28px;
    stroke:currentColor;
    fill:none;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

#carritoIcono:hover{
    background:#7be0c4;
    transform:scale(1.07);
}

#cantidadCarrito{
    position:absolute;
    top:-4px;
    right:-4px;
    min-width:24px;
    height:24px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#0e2a4d;
    color:white;
    border:2px solid white;
    border-radius:50%;
    padding:0 4px;
    font-size:12px;
    font-weight:bold;
}

/* ---------- SIDEBAR DEL CARRITO ---------- */

#fondo{
    display:none;
    position:fixed;
    inset:0;
    background:#0008;
    z-index:1100;
}

#fondo.activo{
    display:block;
}

#sidebar{
    position:fixed;
    top:0;
    right:-420px;
    width:400px;
    max-width:90%;
    height:100vh;
    background:white;
    padding:25px;
    overflow-y:auto;
    box-shadow:-5px 0 20px #0003;
    transition:.3s;
    z-index:1200;
}

#sidebar.activo{
    right:0;
}

#cerrarCarrito{
    float:right;
    border:0;
    border-radius:50%;
    padding:8px;
    background:#eaf8fc;
    cursor:pointer;
}

#contenidoCarrito{
    margin-top:30px;
}

.productoCarrito{
    padding:15px;
    margin-bottom:15px;
    border-radius:12px;
    background:#f2fbfe;
    border:1px solid #d6edf5;
}

.productoCarrito img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:8px;
    float:left;
    margin-right:12px;
}

.productoCarrito:after{
    content:"";
    display:block;
    clear:both;
}

#totalCarrito{
    margin-top:20px;
    padding:15px;
    border-radius:10px;
    background:#dff7ee;
}

#vaciarCarrito,
#comprar{
    width:100%;
    margin-top:10px;
    padding:12px;
    border:0;
    border-radius:9px;
    background:#0e2a4d;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

/* ---------- MODAL DE COMPRA ---------- */

#modalCompra{
    display:none;
    position:fixed;
    inset:0;
    background:#0009;
    align-items:center;
    justify-content:center;
    z-index:1300;
}

#formularioPedido{
    width:450px;
    max-width:90%;
    background:white;
    border-radius:16px;
    padding:30px;
}

#formularioPedido h2{
    text-align:center;
    margin-bottom:20px;
}

#formularioPedido input,
#formularioPedido select{
    width:100%;
    padding:11px;
    margin:7px 0;
    border:1px solid #c9e5ee;
    border-radius:8px;
}

#formularioPedido input.error{
    border-color:#dc3545;
}

#formularioPedido label.error{
    display:block;
    color:#dc3545;
    font-size:12px;
    font-weight:bold;
    margin-bottom:4px;
}

#confirmarPedido,
#cancelarCompra{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:0;
    border-radius:9px;
    font-weight:bold;
    cursor:pointer;
}

#confirmarPedido{
    background:#0e2a4d;
    color:white;
}

#cancelarCompra{
    background:#eaf7fb;
    color:#0e2a4d;
}

.swal2-container{
    z-index:2000 !important;
}

@media(max-width:1000px){
    #productos{
        grid-template-columns:repeat(3,1fr);
    }
}

@media(max-width:750px){
    #productos{
        grid-template-columns:repeat(2,1fr);
    }

    .tarjeta img{
        height:200px;
    }
}

@media(max-width:500px){
    #productos{
        grid-template-columns:1fr;
    }

    .tarjeta img{
        height:260px;
    }

    .acciones{
        flex-direction:column;
        align-items:center;
    }

    .btn-dragonice{
        width:220px;
    }
}

</style>

</head>

<body>

<?php $rutaMenu = "../"; include("../paginaprincipal/menu.php"); ?>

<main class="contenido">

    <h1 class="titulo">CARRITO</h1>

    <p class="subtitulo">Elige tus productos favoritos y realiza tu pedido.</p>

    <div class="acciones">

        <button id="generarPedido" class="btn-dragonice">
            Generar nuevo pedido
        </button>

        <a href="consultar_pedido.php" class="btn-dragonice secundario">
            Consultar pedido
        </a>

    </div>

    <h2 class="titulo">Nuestros productos</h2>

    <section id="productos"></section>

</main>

<button id="carritoIcono" type="button" aria-label="Abrir carrito">
    <svg viewBox="0 0 24 24"><path d="M3 4h2l2.4 12.4a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.6L21 8H6"></path><circle cx="9" cy="21" r="1.4"></circle><circle cx="18" cy="21" r="1.4"></circle></svg>
    <span id="cantidadCarrito">0</span>
</button>

<div id="fondo"></div>

<aside id="sidebar">

    <div>
        <h2>Mi carrito</h2>
        <button id="cerrarCarrito">✖</button>
    </div>

    <div id="contenidoCarrito"></div>

    <h3 id="totalCarrito">Total: Bs 0</h3>

    <button id="vaciarCarrito">Vaciar carrito</button>

    <button id="comprar">Comprar</button>

</aside>

<div id="modalCompra">

    <form id="formularioPedido">

        <h2>Finalizar compra</h2>

        <input type="text" id="nombre" name="nombre" placeholder="Nombre completo">

        <input type="text" id="telefono" name="telefono" placeholder="Teléfono (8 dígitos)">

        <input type="text" id="direccion" name="direccion" placeholder="Dirección">

        <select id="metodoPago" name="metodoPago">
            <option value="QR">Pago mediante QR</option>
            <option value="Efectivo">Pago en efectivo</option>
        </select>

        <button type="button" id="confirmarPedido">Confirmar compra</button>

        <button type="button" id="cancelarCompra">Cancelar</button>

    </form>

</div>

<?php include("../paginaprincipal/piedepagina.php"); ?>

<script src="js/productos.js"></script>
<script src="js/pedido.js"></script>
<script src="js/carrito.js"></script>

<script>
$(document).ready(function(){

    $.validator.addMethod("soloLetras", function(value, element){
        return this.optional(element) || /^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]+$/.test(value);
    }, "Ingrese solo letras");

    $("#formularioPedido").validate({

        rules:{
            nombre:{
                required:true,
                minlength:3,
                maxlength:80,
                soloLetras:true
            },
            telefono:{
                required:true,
                digits:true,
                minlength:8,
                maxlength:8
            },
            direccion:{
                required:true,
                minlength:5,
                maxlength:100
            },
            metodoPago:{
                required:true
            }
        },

        messages:{
            nombre:{
                required:"Ingrese su nombre",
                minlength:"El nombre debe tener al menos 3 caracteres",
                maxlength:"El nombre no puede pasar de 80 caracteres"
            },
            telefono:{
                required:"Ingrese su teléfono",
                digits:"Ingrese solo números",
                minlength:"El teléfono debe tener 8 dígitos",
                maxlength:"El teléfono debe tener 8 dígitos"
            },
            direccion:{
                required:"Ingrese su dirección",
                minlength:"Ingrese una dirección más completa",
                maxlength:"La dirección no puede pasar de 100 caracteres"
            },
            metodoPago:{
                required:"Seleccione un método de pago"
            }
        },

        submitHandler:function(){
            $("#confirmarPedido").click();
        }

    });

});
</script>

</body>
</html>