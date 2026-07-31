<?php
session_start();
if(!isset($_SESSION['rol'])){header("Location: iniciosesion.php");exit();}
if($_SESSION['rol']!='Vendedor'){header("Location: paginaprincipal/02.admin.php");exit();}
include("conexion.php");
$idPedido=isset($_GET['idPedido'])?$_GET['idPedido']:0;$ci=$_SESSION['ci'];
$pedido=$conexion->query("SELECT * FROM pedidos WHERE id='$idPedido' AND vendedor_ci='$ci'");if($pedido->num_rows==0){header("Location: pedidos.php");exit();}$datoPedido=$pedido->fetch_assoc();
$productos=$conexion->query("SELECT * FROM productos ORDER BY nombre");
$detalle=$conexion->query("SELECT c.*,p.nombre,p.precio,p.stock FROM carrito c INNER JOIN productos p ON c.productos_id=p.id WHERE c.pedidos_id='$idPedido'");
$t=$conexion->query("SELECT IFNULL(SUM(costototal),0) AS total FROM carrito WHERE pedidos_id='$idPedido'")->fetch_assoc();$total=$t['total'];
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mi Carrito | Dragon Ice</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial, Helvetica, sans-serif;
}

body{

background-image:url("1 (4).png");

background-size:cover;

background-position:center;

background-attachment:fixed;

color:white;

}

.contenedor{

width:90%;

margin:auto;

padding:40px 0;

}

.tarjeta{

background:rgb(125,197,197);

padding:25px;

border-radius:20px;

margin-bottom:30px;

box-shadow:0 10px 20px rgba(0,0,0,.4);

}

.tarjeta h1{

margin-bottom:10px;

}

table{

width:100%;

border-collapse:collapse;

background:white;

color:black;

border-radius:20px;

overflow:hidden;

}

th{

background:#79ecf0e6;

padding:15px;

}

td{

padding:15px;

text-align:center;

}

tr:nth-child(even){

background:#f5f5f5;

}

input[type=number]{

width:70px;

padding:8px;

border-radius:8px;

border:1px solid gray;

}

button{

padding:10px 18px;

border:none;

background:#0d6efd;

color:white;

border-radius:10px;

cursor:pointer;

transition:.3s;

}

button:hover{

background:#084298;

transform:scale(1.05);

}

.btnNuevo{

margin-top:25px;

}

</style>

</head>
<body><?php $rutaMenu=""; include("menu.php");?><div class="contenedor"><div class="tarjeta"><h1>🍦 Mi Carrito</h1><h2>Pedido #<?php echo $idPedido; ?> - Cliente: <?php echo $datoPedido['nombre']; ?></h2><h2>Total: Bs. <?php echo $total; ?></h2></div><table><tr><th>ID</th><th>Producto</th><th>Descripción</th><th>Precio</th><th>Stock</th><th>Cantidad</th><th>Agregar</th></tr><?php while($fila=$productos->fetch_assoc()){?><form action="agregarCarrito.php" method="POST"><tr><td><?php echo $fila['id'];?></td><td><?php echo $fila['nombre'];?></td><td><?php echo $fila['descripcion'];?></td><td>Bs. <?php echo $fila['precio'];?></td><td><?php echo $fila['stock'];?></td><input type="hidden" name="idProducto" value="<?php echo $fila['id'];?>"><input type="hidden" name="idPedido" value="<?php echo $idPedido;?>"><td><input type="number" name="cantidad" min="1" value="1" required></td><td><button type="submit">🛒 Agregar</button></td></tr></form><?php }?></table><br><div class="tarjeta"><h2>Productos agregados</h2></div><table><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acciones</th></tr><?php if($detalle->num_rows>0){while($fila=$detalle->fetch_assoc()){?><tr><td><?php echo $fila['nombre'];?></td><td>Bs. <?php echo $fila['precio'];?></td><td><form action="actualizarCarrito.php" method="POST"><input type="hidden" name="idPedido" value="<?php echo $idPedido;?>"><input type="hidden" name="idProducto" value="<?php echo $fila['productos_id'];?>"><input type="number" name="cantidad" min="1" max="<?php echo $fila['stock'];?>" value="<?php echo $fila['cantidad'];?>"><button type="submit">Actualizar</button></form></td><td>Bs. <?php echo $fila['costototal'];?></td><td><a href="eliminarCarrito.php?idPedido=<?php echo $idPedido;?>&idProducto=<?php echo $fila['productos_id'];?>"><button>Eliminar</button></a></td></tr><?php }}else{?><tr><td colspan="5">Todavía no agregó productos.</td></tr><?php }?></table><a href="pedidos.php"><button class="btnNuevo">Terminar pedido</button></a><a href="formpedido.php"><button class="btnNuevo">Nuevo pedido</button></a></div></body></html>

</html>