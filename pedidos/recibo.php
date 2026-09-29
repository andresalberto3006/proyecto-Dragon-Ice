<?php
session_start();
require 'php/conexion.php';

if(!isset($_SESSION['pedido'])) exit('No existe pedido activo');

$id=(int)$_SESSION['pedido'];

$s=$conn->prepare('SELECT id,nombre,telefono,direccion,metodo_pago,estado FROM pedidos WHERE id=? LIMIT 1');
$s->bind_param('i',$id);
$s->execute();
$pedido=$s->get_result()->fetch_assoc();

if(!$pedido) exit('Pedido no encontrado');

$s=$conn->prepare('SELECT p.nombre,c.cantidad,c.costototal FROM carrito c INNER JOIN productos p ON c.productos_id=p.id WHERE c.pedidos_id=?');
$s->bind_param('i',$id);
$s->execute();
$r=$s->get_result();

$total=0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recibo - Dragon Ice</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}

body{min-height:100vh;background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);padding:40px}

.contenedor{max-width:1000px;margin:auto;background:white;padding:30px;border-radius:25px;box-shadow:0 10px 30px rgba(0,0,0,.25)}

h1{text-align:center;color:#18335c;margin-bottom:30px}

.subtitulo{color:#18335c;font-size:18px;margin-bottom:15px;padding-bottom:8px;border-bottom:3px solid #4da6ff;display:inline-block}

.info{display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:30px}

.item{background:#f4f8ff;border-radius:12px;padding:15px 18px}
.item b{display:block;font-size:13px;color:#5b7590;text-transform:uppercase;margin-bottom:5px}
.item span{font-size:17px;color:#18335c;font-weight:bold}

table{width:100%;border-collapse:collapse;margin-bottom:25px}
th{background:#4da6ff;color:white;padding:15px}
td{padding:12px;text-align:center;border-bottom:1px solid #ddd}
tr:hover{background:#f4f8ff}

.total{background:#18335c;color:white;padding:16px;border-radius:10px;text-align:right;font-weight:bold}
.total span{color:#7be0c4;font-size:20px}

.mensaje{text-align:center;background:#f4f8ff;color:#5b7590;padding:15px;border-radius:12px;margin-top:20px}

.botones{display:flex;justify-content:center;gap:15px;margin-top:30px}
button{border:0;padding:15px 25px;border-radius:10px;color:white;font-weight:bold;cursor:pointer}
.imprimir{background:#4da6ff}
.volver{background:#18335c}

@media(max-width:700px){
    body{padding:15px}
    .contenedor{padding:20px}
    .info{grid-template-columns:1fr}
    .botones{flex-direction:column}
    button{width:100%}
}

@media print{
    body{background:white;padding:0}
    .contenedor{box-shadow:none}
    .no-imprimir{display:none}
}
</style>
</head>

<body>

<div class="contenedor">

<h1>Recibo del Pedido #<?php echo $pedido['id']; ?></h1>

<h3 class="subtitulo">Información del pedido</h3>

<div class="info">

<div class="item">
<b>Cliente</b>
<span><?php echo htmlspecialchars($pedido['nombre']); ?></span>
</div>

<div class="item">
<b>Teléfono</b>
<span><?php echo htmlspecialchars($pedido['telefono']); ?></span>
</div>

<div class="item">
<b>Dirección</b>
<span><?php echo htmlspecialchars($pedido['direccion']); ?></span>
</div>

<div class="item">
<b>Método de pago</b>
<span><?php echo htmlspecialchars($pedido['metodo_pago']); ?></span>
</div>

<div class="item">
<b>Estado</b>
<span><?php echo htmlspecialchars($pedido['estado']); ?></span>
</div>

</div>

<h3 class="subtitulo">Productos del pedido</h3>

<table>
<tr>
<th>Producto</th>
<th>Cantidad</th>
<th>Subtotal</th>
</tr>

<?php while($p=$r->fetch_assoc()){ $total+=(float)$p['costototal']; ?>

<tr>
<td><?php echo htmlspecialchars($p['nombre']); ?></td>
<td><?php echo $p['cantidad']; ?></td>
<td>Bs. <?php echo number_format($p['costototal'],2); ?></td>
</tr>

<?php } ?>

</table>

<div class="total">
TOTAL: <span>Bs. <?php echo number_format($total,2); ?></span>
</div>

<div class="mensaje">
Esperando aprobación del vendedor.
</div>

<div class="botones no-imprimir">

<button class="imprimir" onclick="window.print()">🖨 Imprimir</button>

<button class="volver" id="volverProductos">Volver a Productos</button>

</div>

</div>

<script>
document.getElementById('volverProductos').addEventListener('click',()=>fetch('php/nueva_compra.php').then(r=>r.json()).then(d=>{if(d.ok)location.href='index.php'}));
</script>

</body>
</html>