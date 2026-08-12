<?php

session_start();

if(!isset($_SESSION['rol'])){
    header("Location: iniciosesion.php");
    exit();
}

if($_SESSION['rol'] != 'Vendedor'){
    header("Location: paginaprincipal/02.admin.php");
    exit();
}

include("conexion.php");

$idPedido = isset($_GET['idPedido']) ? $_GET['idPedido'] : 0;
$ci = $_SESSION['ci'];

$pedido = $conexion->query("SELECT * FROM pedidos WHERE id='$idPedido' AND vendedor_ci='$ci'");

if($pedido->num_rows == 0){
    header("Location: pedidos.php");
    exit();
}

$datoPedido = $pedido->fetch_assoc();

$productos = $conexion->query("SELECT * FROM productos ORDER BY nombre");

$detalle = $conexion->query("
    SELECT c.*,p.nombre,p.precio,p.stock
    FROM carrito c
    INNER JOIN productos p ON c.productos_id=p.id
    WHERE c.pedidos_id='$idPedido'
");

$t = $conexion->query("
    SELECT IFNULL(SUM(costototal),0) AS total
    FROM carrito
    WHERE pedidos_id='$idPedido'
")->fetch_assoc();

$total = $t['total'];

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
    font-family:Arial,Helvetica,sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    background-attachment:fixed;
    color:#18335c;
}

.contenedor{
    width:90%;
    max-width:1200px;
    margin:auto;
    padding:40px 0 50px;
}

.tarjeta{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.20);
}

.tarjeta h1{
    color:#18335c;
    margin-bottom:10px;
    font-size:28px;
}

.tarjeta h2{
    color:#2f5d9f;
    font-size:18px;
    margin-top:7px;
}

.titulo-seccion{
    color:white;
    text-align:center;
    margin:25px 0 15px;
    font-size:22px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    color:#18335c;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
    margin-bottom:25px;
}

th{
    background:#4da6ff;
    color:white;
    padding:15px;
}

td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #e3edf8;
}

tr:nth-child(even){
    background:#f4f9ff;
}

tr:hover{
    background:#e8f4ff;
}

input[type=number]{
    width:70px;
    padding:8px;
    border-radius:8px;
    border:2px solid #d7eaff;
    background:#f4f9ff;
    color:#18335c;
    text-align:center;
}

button{
    padding:10px 18px;
    border:none;
    background:#4da6ff;
    color:white;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
    transition:.3s;
}

button:hover{
    background:#2f5d9f;
    transform:scale(1.03);
}

.botones-finales{
    display:flex;
    justify-content:center;
    gap:15px;
    margin-top:30px;
    margin-bottom:10px;
}

.botones-finales a{
    text-decoration:none;
}

.btnNuevo{
    min-width:180px;
    padding:14px 20px;
    font-size:16px;
    background:#18335c;
}

.btnNuevo:hover{
    background:#2f5d9f;
}

@media(max-width:800px){

    .contenedor{
        width:95%;
        padding:25px 0;
    }

    table{
        display:block;
        overflow-x:auto;
        white-space:nowrap;
    }

    .botones-finales{
        flex-direction:column;
    }

    .btnNuevo{
        width:100%;
    }

}

</style>

</head>

<body>

<?php
$rutaMenu="";
include("menu.php");
?>

<div class="contenedor">

    <div class="tarjeta">

        <h1> Mi Carrito</h1>

        <h2>
            Pedido #<?php echo $idPedido; ?> -
            Cliente: <?php echo $datoPedido['nombre']; ?>
        </h2>

        <h2>
            Total: Bs. <?php echo $total; ?>
        </h2>

    </div>

    <h2 class="titulo-seccion"> Productos disponibles</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Cantidad</th>
            <th>Agregar</th>
        </tr>

        <?php while($fila=$productos->fetch_assoc()){ ?>

        <form action="agregarCarrito.php" method="POST">

            <tr>

                <td><?php echo $fila['id']; ?></td>

                <td><?php echo $fila['nombre']; ?></td>

                <td><?php echo $fila['descripcion']; ?></td>

                <td>Bs. <?php echo $fila['precio']; ?></td>

                <td><?php echo $fila['stock']; ?></td>

                <input
                    type="hidden"
                    name="idProducto"
                    value="<?php echo $fila['id']; ?>"
                >

                <input
                    type="hidden"
                    name="idPedido"
                    value="<?php echo $idPedido; ?>"
                >

                <td>
                    <input
                        type="number"
                        name="cantidad"
                        min="1"
                        value="1"
                        required
                    >
                </td>

                <td>
                    <button type="submit"> Agregar</button>
                </td>

            </tr>

        </form>

        <?php } ?>

    </table>

    <h2 class="titulo-seccion"> Productos agregados</h2>

    <table>

        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acciones</th>
        </tr>

        <?php

        if($detalle->num_rows > 0){

            while($fila=$detalle->fetch_assoc()){

        ?>

        <tr>

            <td><?php echo $fila['nombre']; ?></td>

            <td>Bs. <?php echo $fila['precio']; ?></td>

            <td>

                <form action="carrito/actualizarCarrito.php" method="POST">

                    <input
                        type="hidden"
                        name="idPedido"
                        value="<?php echo $idPedido; ?>"
                    >

                    <input
                        type="hidden"
                        name="idProducto"
                        value="<?php echo $fila['productos_id']; ?>"
                    >

                    <input
                        type="number"
                        name="cantidad"
                        min="1"
                        max="<?php echo $fila['stock']; ?>"
                        value="<?php echo $fila['cantidad']; ?>"
                    >

                    <button type="submit">Actualizar</button>

                </form>

            </td>

            <td>
                Bs. <?php echo $fila['costototal']; ?>
            </td>

            <td>

                <a href="eliminarCarrito.php?idPedido=<?php echo $idPedido; ?>&idProducto=<?php echo $fila['productos_id']; ?>">

                    <button type="button">
                         Eliminar
                    </button>

                </a>

            </td>

        </tr>

        <?php

            }

        }else{

        ?>

        <tr>
            <td colspan="5">
                Todavía no agregó productos.
            </td>
        </tr>

        <?php } ?>

    </table>

    <div class="botones-finales">

        <a href="pedidos.php">
            <button class="btnNuevo"> Terminar pedido</button>
        </a>

        <a href="formpedido.php">
            <button class="btnNuevo"> Nuevo pedido</button>
        </a>

    </div>

</div>

<?php include("paginaprincipal/piedepagina.php"); ?>

</body>

</html>