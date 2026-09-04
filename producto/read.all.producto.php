<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'Vendedor') { header("Location: ../iniciosesion.php"); exit(); }
include("../conexion.php");
$resultado=$conexion->query("SELECT * FROM productos ORDER BY id DESC");
$resultado = $conexion->query("SELECT * FROM productos ORDER BY id DESC");
$productos = $resultado->fetch_all(MYSQLI_ASSOC);

$STOCK_MINIMO = 5; // ajusta el umbral que consideres "bajo"

$productosBajoStock = array_filter($productos, function($p) use ($STOCK_MINIMO) {
    return $p['stock'] <= $STOCK_MINIMO;
});
$rutaMenu = "../";
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos</title>

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
margin:auto;
background:white;
padding:30px;
border-radius:25px;
box-shadow:0 10px 30px rgba(0,0,0,.25);
}

h1{
text-align:center;
color:#18335c;
margin-bottom:25px;
}

table{
width:100%;
border-collapse:collapse;
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
padding:8px 12px;
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
.stock-bajo{
    color:#dc3545;
    font-weight:bold;
}

.stock-critico{
    color:#ffffff;
    background:#dc3545;
    padding:3px 10px;
    border-radius:6px;
    font-weight:bold;
}

.alerta-stock{
    background:#fff3cd;
    border:1px solid #ffc107;
    color:#856404;
    padding:15px 20px;
    border-radius:12px;
    margin-bottom:20px;
}

.alerta-stock h3{
    margin-bottom:8px;
}

.alerta-stock ul{
    margin-left:20px;
}
</style>
</head>
<body>
    <?php include("../menu.php"); ?>
    
    <main class="fondo-panel">
     <div class="contenedor">
        <h1> Lista de Productos Registrados</h1>
        <?php if (count($productosBajoStock) > 0) { ?>
    <div class="alerta-stock">
        <h3>⚠️ Aviso de stock bajo</h3>
        <p>Los siguientes productos tienen poco stock, considera reponerlos pronto:</p>
        <ul>
            <?php foreach ($productosBajoStock as $p) { ?>
                <li><?php echo htmlspecialchars($p['nombre']); ?> — quedan <?php echo $p['stock']; ?> unidades</li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Costo</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            <?php if(count($productos)>0){ foreach($productos as $fila){
    $claseStock = '';
    if ($fila['stock'] <= 0) {
        $claseStock = 'stock-critico';   // sin stock
    } elseif ($fila['stock'] <= $STOCK_MINIMO) {
        $claseStock = 'stock-bajo';      // stock bajo
    }
?>
<tr>
    <td><?php echo $fila['id'];?></td>
    <td><?php echo $fila['nombre'];?></td>
    <td><?php echo $fila['descripcion'];?></td>
    <td><?php echo $fila['precio'];?></td>
    <td><?php echo $fila['costo'];?></td>
    <td class="<?php echo $claseStock; ?>"><?php echo $fila['stock'];?></td>
    <td><img src="../<?php echo $fila['imagen'];?>" width="60"></td>
    <td>
        <div class="acciones">
            <a class="boton mostrar" href="readproducto.php?id=<?php echo $fila['id'];?>">Mostrar</a>
            <a class="boton editar" href="updateproducto.php?id=<?php echo $fila['id'];?>">Editar</a>
            <a class="boton eliminar" href="delete_producto.php?id=<?php echo $fila['id'];?>">Eliminar</a>
        </div>
    </td>
</tr>
<?php }}else{ ?>
<tr>
    <td colspan="8">No existen productos registrados.</td>
</tr>
<?php } ?>
        </table>
        <a href="formularioproducto.php" class="volver"> Registrar Nuevo Producto</a>
        <?php if($_SESSION['rol']=='Administrador'){ ?>
            <a href="../paginaprincipal/02.admin.php" class="volver">Volver al panel</a>
        <?php }else{ ?>
            <a href="../paginaprincipal/vendedor20.php" class="volver">Volver al panel</a>
        <?php } ?>
     </div>
    </main>
    <?php include("../paginaprincipal/piedepagina.php"); ?>
</body>
</html>