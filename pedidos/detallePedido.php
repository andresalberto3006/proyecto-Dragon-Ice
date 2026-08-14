<?php
session_start();
if(!isset($_SESSION['rol'])){header("Location: ../iniciosesion.php");exit();}
include("../conexion.php");
$id=isset($_GET['id'])?$_GET['id']:0;
if($_SESSION['rol']=='Administrador'){$pedido=$conexion->query("SELECT * FROM pedidos WHERE id='$id'");}else{$ci=$_SESSION['ci'];$pedido=$conexion->query("SELECT * FROM pedidos WHERE id='$id' AND vendedor_ci='$ci'");}
if($pedido->num_rows==0){header("Location: pedidos.php");exit();}
$p=$pedido->fetch_assoc();
$detalle=$conexion->query("SELECT c.*,pr.nombre,pr.precio FROM carrito c INNER JOIN productos pr ON c.productos_id=pr.id WHERE c.pedidos_id='$id'");

// --- Generación del código QR (Opción 1: API externa) ---
$datoQR = "Pedido #" . $p['id'] . " | Cliente: " . $p['nombre'] . " | Estado: " . $p['estado'];
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=" . urlencode($datoQR);

$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle del Pedido</title>
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

/* --- Layout de dos columnas --- */
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

/* --- Tarjeta del QR --- */
.tarjeta-qr{
    background:#f4f8ff;
    border:2px solid #4da6ff;
    border-radius:20px;
    padding:25px;
    text-align:center;
    width:100%;
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

/* --- Tarjetas de información del pedido --- */
.info-pedido{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    margin-bottom:30px;
}

.info-item{
    background:#f4f8ff;
    border-left:6px solid #4da6ff;
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

/* Colores especiales según el estado */
.estado-Pendiente{ border-left-color:#ffb200; }
.estado-Pendiente .valor{ color:#c98600; }

.estado-En-proceso{ border-left-color:#0d6efd; }

.estado-Entregado{ border-left-color:#28a745; }
.estado-Entregado .valor{ color:#28a745; }

.estado-Rechazado{ border-left-color:#dc3545; }
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

@media(max-width:800px){
    .layout{
        flex-direction:column;
    }
    .info-pedido{
        grid-template-columns:1fr;
    }
}

</style>
</head>
<body>

<?php include("../menu.php"); ?>

<main class="fondo-panel">
    <div class="contenedor">
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

            
            <div class="columna-derecha">
                <div class="tarjeta-qr">
                    <h2> Código QR del pedido</h2>
                    <img src="<?php echo $qrUrl; ?>" alt="QR Pedido #<?php echo $p['id']; ?>">
                    <p>Escanea para verificar el pedido #<?php echo $p['id'];?></p>
                </div>
            </div>

        </div>

        <a href="../pedidos/pedidos.php" class="volver">Volver a pedidos</a>
    </div>
</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

</body>
</html>