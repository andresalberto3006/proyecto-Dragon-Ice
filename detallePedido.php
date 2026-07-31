<?php
session_start();if(!isset($_SESSION['rol'])){header("Location: iniciosesion.php");exit();}include("conexion.php");$id=isset($_GET['id'])?$_GET['id']:0;if($_SESSION['rol']=='Administrador'){$pedido=$conexion->query("SELECT * FROM pedidos WHERE id='$id'");}else{$ci=$_SESSION['ci'];$pedido=$conexion->query("SELECT * FROM pedidos WHERE id='$id' AND vendedor_ci='$ci'");}if($pedido->num_rows==0){header("Location: pedidos.php");exit();}$p=$pedido->fetch_assoc();$detalle=$conexion->query("SELECT c.*,pr.nombre,pr.precio FROM carrito c INNER JOIN productos pr ON c.productos_id=pr.id WHERE c.pedidos_id='$id'");?>
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

body{
    min-height:100vh;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:40px;
}

.contenedor{

    max-width:1200px;
    margin:auto;

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

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
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

.boton{

    text-decoration:none;

    color:white;

    padding:8px 15px;

    border-radius:8px;

    font-size:14px;

    font-weight:bold;
}

.mostrar{
    background:#4da6ff;
}

.editar{
    background:#28a745;
}

.eliminar{
    background:#dc3545;
}

.acciones{
    display:flex;
    justify-content:center;
    gap:8px;
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

</style>
</head>
<body><div class="contenedor"><h1>🍦 Detalle del Pedido #<?php echo $p['id'];?></h1><table><tr><th>Cliente</th><th>Fecha</th><th>Estado</th><th>Vendedor</th><th>Método de pago</th></tr><tr><td><?php echo $p['nombre'];?></td><td><?php echo $p['fecha'];?></td><td><?php echo $p['estado'];?></td><td><?php echo $p['nombrevendedor'];?></td><td><?php echo $p['metodo_pago'];?></td></tr></table><br><table><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th></tr><?php $total=0;while($f=$detalle->fetch_assoc()){$total=$total+$f['costototal'];?><tr><td><?php echo $f['nombre'];?></td><td>Bs. <?php echo $f['precio'];?></td><td><?php echo $f['cantidad'];?></td><td>Bs. <?php echo $f['costototal'];?></td></tr><?php }?><tr><th colspan="3">Total</th><th>Bs. <?php echo $total;?></th></tr></table><a href="pedidos.php" class="volver">Volver a pedidos</a></div></body></html>