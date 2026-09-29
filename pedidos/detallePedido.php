<?php
session_start();
include("../conexion.php");
$id=isset($_GET['id'])?intval($_GET['id']):0;

$esCliente = !isset($_SESSION['rol']) && isset($_SESSION['pedido']) && (int)$_SESSION['pedido']===$id;

if(!isset($_SESSION['rol']) && !$esCliente){header("Location: ../iniciarsesion/iniciosesion.php");exit();}

if($esCliente || $_SESSION['rol']=='Administrador'){
    $pedido=$conexion->query("SELECT * FROM pedidos WHERE id='$id'");
}else{
    $ci=$_SESSION['ci'];
    $pedido=$conexion->query("SELECT * FROM pedidos WHERE id='$id' AND (vendedor_ci='$ci' OR (vendedor_ci IS NULL AND estado='Pendiente'))");
}
if($pedido->num_rows==0){header("Location: ".($esCliente?"../carritoAjaxCliente/index.php":"pedidos.php"));exit();}
$p=$pedido->fetch_assoc();
$detalle=$conexion->query("SELECT c.*,pr.nombre,pr.precio FROM carrito c INNER JOIN productos pr ON c.productos_id=pr.id WHERE c.pedidos_id='$id'");

$datoQR = "Pedido #" . $p['id'] . " | Cliente: " . $p['nombre'] . " | Estado: " . $p['estado'];
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=" . urlencode($datoQR);

$qrPago = "../imagenesproyecto/qr_pago.jpeg";
$puedePagar = ($p['estado'] != 'Entregado' && $p['estado'] != 'Rechazado');

$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle del Pedido</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

html, body{
    height:100%;
}

body{
    display:flex;
    flex-direction:column;
    min-height:100vh;
}

.fondo-panel{
    flex:1;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:40px;
    display:flex;
    justify-content:center;
    align-items:flex-start;
}

.contenedor{
    max-width:1200px;
    width:100%;
    background:white;
    padding:30px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

h1{
    text-align:center;
    color:#18335c;
    margin-bottom:30px;
}

.layout{
    display:flex;
    gap:30px;
    align-items:flex-start;
    flex-wrap:wrap;
}

.columna-izquierda{
    flex:1 1 60%;
    min-width:320px;
}

.columna-derecha{
    flex:1 1 30%;
    min-width:260px;
    display:flex;
    flex-direction:column;
    align-items:center;
}

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    margin-bottom:25px;
}

th{
    background:#4da6ff;
    color:white;
    padding:15px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f4f8ff;
}

.tarjeta-qr{
    background:#f4f8ff;
    border:2px solid #4da6ff;
    border-radius:20px;
    padding:25px;
    text-align:center;
    width:100%;
    page-break-inside:avoid;
    break-inside:avoid;
}

.info-item,
table tr{
    page-break-inside:avoid;
    break-inside:avoid;
}

.tarjeta-qr h2{
    color:#18335c;
    font-size:18px;
    margin-bottom:15px;
}

.tarjeta-qr img{
    width:260px;
    height:260px;
    border-radius:12px;
    background:white;
    padding:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
}

.tarjeta-qr p{
    margin-top:15px;
    font-size:14px;
    color:#555;
}

.info-pedido{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    margin-bottom:30px;
}

.info-item{
    background:#f4f8ff;
    border-radius:12px;
    padding:15px 18px;
}

.info-item .etiqueta{
    font-size:13px;
    color:#5b7590;
    font-weight:bold;
    text-transform:uppercase;
    letter-spacing:0.5px;
    margin-bottom:5px;
}

.info-item .valor{
    font-size:17px;
    color:#18335c;
    font-weight:bold;
}

.estado-Pendiente .valor{ color:#c98600; }
.estado-Entregado .valor{ color:#28a745; }
.estado-Rechazado .valor{ color:#dc3545; }

.subtitulo-seccion{
    color:#18335c;
    font-size:18px;
    margin-bottom:15px;
    padding-bottom:8px;
    border-bottom:3px solid #4da6ff;
    display:inline-block;
}

.volver{
    display:block;
    width:250px;
    margin:30px auto 0;
    text-align:center;
    text-decoration:none;
    background:#18335c;
    color:white;
    padding:15px;
    border-radius:10px;
    font-weight:bold;
}

.volver:hover{
    background:#2f5d9f;
}

.botones-accion{
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
    margin-top:30px;
}

.boton-accion{
    border:none;
    cursor:pointer;
    text-decoration:none;
    color:white;
    padding:15px 25px;
    border-radius:10px;
    font-weight:bold;
    font-size:15px;
    transition:.3s;
}

.boton-imprimir{
    background:#4da6ff;
}

.boton-imprimir:hover{
    background:#2f5d9f;
}

.boton-descargar{
    background:#28a745;
}

.boton-descargar:hover{
    background:#1e7e34;
}

.boton-pagar{
    background:#0e2a4d;
}

.boton-pagar:hover{
    background:#63d4f2;
    color:#0e2a4d;
}

#modalPago{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    align-items:center;
    justify-content:center;
    z-index:2000;
    padding:20px;
}

#modalPago.activo{
    display:flex;
}

.modal-pago-caja{
    background:white;
    border-radius:20px;
    padding:30px;
    max-width:420px;
    width:100%;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.35);
}

.modal-pago-caja h2{
    color:#18335c;
    margin-bottom:8px;
}

.modal-pago-caja .monto{
    font-size:22px;
    font-weight:bold;
    color:#159db9;
    margin-bottom:15px;
}

.modal-pago-caja img{
    width:100%;
    max-width:320px;
    height:auto;
    border-radius:12px;
    border:2px solid #4da6ff;
}

.modal-pago-caja p{
    margin-top:12px;
    font-size:14px;
    color:#555;
}

.modal-pago-caja button{
    margin-top:18px;
    border:none;
    cursor:pointer;
    background:#18335c;
    color:white;
    padding:12px 30px;
    border-radius:10px;
    font-weight:bold;
}

.modal-pago-caja button:hover{
    background:#2f5d9f;
}

@media(max-width:800px){
    .layout{
        flex-direction:column;
    }
    .info-pedido{
        grid-template-columns:1fr;
    }
}

@media print{
    .dragonice-nav,
    .pie,
    .no-imprimir,
    #modalPago{
        display:none !important;
    }
    body{
        background:white;
    }
    .fondo-panel{
        background:white;
        padding:0;
    }
    .contenedor{
        box-shadow:none;
        border-radius:0;
        padding:10px;
    }
    .layout{
        flex-wrap:nowrap !important;
        gap:15px;
    }
    .columna-izquierda{
        flex:1 1 100% !important;
        min-width:0 !important;
    }
    #columnaQR{
        display:none !important;
    }
}

</style>
</head>
<body>

<?php include("../paginaprincipal/menu.php"); ?>

<main class="fondo-panel">
    <div class="contenedor">

        <div id="contenidoPDF">

            <h1> Detalle del Pedido #<?php echo $p['id'];?></h1>

            <div class="layout">


                <div class="columna-izquierda">

                    <h3 class="subtitulo-seccion"> Información general</h3>

                    <div class="info-pedido">
                        <div class="info-item">
                            <div class="etiqueta"> Cliente</div>
                            <div class="valor"><?php echo $p['nombre'];?></div>
                        </div>
                        <div class="info-item">
                            <div class="etiqueta"> Fecha</div>
                            <div class="valor"><?php echo $p['fecha'];?></div>
                        </div>
                        <div class="info-item estado-<?php echo str_replace(' ','-',$p['estado']);?>">
                            <div class="etiqueta"> Estado</div>
                            <div class="valor"><?php echo $p['estado'];?></div>
                        </div>
                        <div class="info-item">
                            <div class="etiqueta"> Vendedor</div>
                            <div class="valor"><?php echo $p['nombrevendedor'];?></div>
                        </div>
                        <div class="info-item" style="grid-column:1 / -1;">
                            <div class="etiqueta"> Método de pago</div>
                            <div class="valor"><?php echo $p['metodo_pago']!=''?$p['metodo_pago']:'Aún no registrado';?></div>
                        </div>
                    </div>

                    <h3 class="subtitulo-seccion"> Productos del pedido</h3>

                    <table>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                        <?php $total=0; while($f=$detalle->fetch_assoc()) { $total=$total+$f['costototal']; ?>
                        <tr>
                            <td><?php echo $f['nombre'];?></td>
                            <td>Bs. <?php echo $f['precio'];?></td>
                            <td><?php echo $f['cantidad'];?></td>
                            <td>Bs. <?php echo $f['costototal'];?></td>
                        </tr>
                        <?php } ?>
                        <tr style="background:#18335c;">
                            <th colspan="3" style="color:white;">TOTAL</th>
                            <th style="color:#7be0c4; font-size:18px;">Bs. <?php echo $total;?></th>
                        </tr>
                    </table>
                </div>


                <div class="columna-derecha" id="columnaQR">
                    <div class="tarjeta-qr">
                        <h2> Código QR del pedido</h2>
                        <img src="<?php echo $qrUrl; ?>" alt="QR Pedido #<?php echo $p['id']; ?>" crossorigin="anonymous">
                        <p>Escanea para verificar el pedido #<?php echo $p['id'];?></p>
                    </div>
                </div>

            </div>

        </div>

        <div class="botones-accion no-imprimir">
            <button type="button" class="boton-accion boton-imprimir" onclick="window.print()">Imprimir</button>
            <button type="button" class="boton-accion boton-descargar" onclick="descargarPDF()">Descargar PDF</button>
            <?php if($puedePagar){ ?>
                <button type="button" class="boton-accion boton-pagar" onclick="abrirPago()">Pagar con QR</button>
            <?php } ?>
        </div>

        <?php if($esCliente){ ?>
                <a href="#" id="volverProductos" class="volver no-imprimir">Volver a productos</a>
        <?php }else{ ?>
                <a href="../pedidos/pedidos.php" class="volver no-imprimir">Volver a pedidos</a>
        <?php } ?>
    </div>
</main>

<?php if($puedePagar){ ?>
<div id="modalPago" class="no-imprimir">
    <div class="modal-pago-caja">
        <h2>Pagar pedido #<?php echo $p['id'];?></h2>
        <div class="monto">Bs. <?php echo $total;?></div>
        <img src="<?php echo $qrPago; ?>" alt="QR de pago">
        <p>Escanea este código con tu app de pagos para pagar el pedido.</p>
        <button type="button" onclick="cerrarPago()">Cerrar</button>
    </div>
</div>
<?php } ?>

<?php include("../paginaprincipal/piedepagina.php"); ?>

<script>
function abrirPago(){
    document.getElementById("modalPago").classList.add("activo");
}

function cerrarPago(){
    document.getElementById("modalPago").classList.remove("activo");
}

var modalPago = document.getElementById("modalPago");
if(modalPago){
    modalPago.addEventListener("click", function(e){
        if(e.target === modalPago){ cerrarPago(); }
    });
}

function descargarPDF(){
    const columnaQR = document.getElementById("columnaQR");
    const elemento = document.getElementById("contenidoPDF");

    columnaQR.style.display = "none";

    const opciones = {
        margin: 10,
        filename: "Pedido_<?php echo $p['id']; ?>.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: {
            scale: 2,
            logging: false
        },
        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
        pagebreak: { mode: ["avoid-all", "css", "legacy"] }
    };

    html2pdf().set(opciones).from(elemento).save().then(function(){
        columnaQR.style.display = "";
    });
}

var volverProductos = document.getElementById("volverProductos");
if(volverProductos){
    volverProductos.addEventListener("click", function(e){
        e.preventDefault();
        fetch("../carritoAjaxCliente/php/nueva_compra.php")
        .then(function(r){ return r.json(); })
        .then(function(d){
            if(d.ok){ location.href = "../carritoAjaxCliente/index.php"; }
        });
    });
}
</script>

</body>
</html>