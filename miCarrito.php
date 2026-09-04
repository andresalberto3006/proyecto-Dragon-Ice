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

$idPedido = isset($_GET['idPedido']) ? intval($_GET['idPedido']) : 0;
$ci = $_SESSION['ci'];

$pedido = $conexion->query("
    SELECT * FROM pedidos
    WHERE id='$idPedido' AND vendedor_ci='$ci'
");

if($pedido->num_rows == 0){
    header("Location: pedidos.php");
    exit();
}

$datoPedido = $pedido->fetch_assoc();

$productos = $conexion->query("
    SELECT * FROM productos
    ORDER BY id DESC
");

$detalle = $conexion->query("
    SELECT c.*,p.nombre,p.precio,p.stock,p.imagen
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

$imagenGenerica = "imagenesproyecto/logo.png";
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mi Carrito | Dragon Ice</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial,Helvetica,sans-serif;
    background:#ffffff;
    color:#0e2a4d;
}

.contenedor{
    width:94%;
    max-width:1500px;
    margin:auto;
    padding:40px 0 60px;
}

.encabezado-pedido{
    background:#0e2a4d;
    color:white;
    border-radius:20px;
    padding:25px 30px;
    margin-bottom:40px;
    box-shadow:0 8px 25px rgba(14,42,77,.2);
}

.encabezado-pedido h1{
    font-size:32px;
    margin-bottom:15px;
}

.datos-pedido{
    display:flex;
    flex-wrap:wrap;
    gap:30px;
}

.dato{
    font-size:17px;
}

.dato strong{
    color:#63d4f2;
}

.titulo-seccion{
    text-align:center;
    margin:35px 0 25px;
}

.titulo-seccion h2{
    font-size:30px;
    color:#0e2a4d;
}

.titulo-seccion p{
    margin-top:7px;
    color:#5b7590;
}

.productos{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:25px;
    margin-bottom:50px;
}

.card{
    min-width:0;
    border-radius:18px;
    overflow:hidden;
    background:white;
    box-shadow:0 6px 20px rgba(14,42,77,.18);
    border:1px solid #e2edf5;
    transition:.3s;
}

.card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 28px rgba(14,42,77,.25);
}

.card-img{
    width:100%;
    height:220px;
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-color:#eaf8fc;
}

.card-info{
    padding:17px;
}

.text-title{
    font-size:20px;
    font-weight:bold;
    color:#0e2a4d;
    margin-bottom:7px;
}

.text-price{
    font-size:19px;
    font-weight:bold;
    color:#159db9;
    margin-bottom:8px;
}

.text-body{
    color:#5b7590;
    font-size:14px;
    line-height:1.4;
    min-height:40px;
    margin-bottom:10px;
}

.stock{
    font-size:14px;
    font-weight:bold;
    color:#0e2a4d;
    margin-bottom:12px;
}

.cantidad{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:8px;
    margin-bottom:10px;
}

.cantidad label{
    font-size:14px;
    font-weight:bold;
}

.cantidad input{
    width:65px;
    padding:8px;
    border:2px solid #63d4f2;
    border-radius:8px;
    text-align:center;
    font-size:15px;
}

.btn{
    width:100%;
    padding:11px;
    border:none;
    border-radius:10px;
    background:#0e2a4d;
    color:white;
    font-size:14px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

.btn:hover{
    background:#1b4a52;
    transform:scale(1.02);
}

.btn:disabled{
    opacity:.6;
    cursor:not-allowed;
}

.btn-eliminar{
    background:#dc3545;
}

.btn-eliminar:hover{
    background:#b02a37;
}

.subtotal{
    font-size:17px;
    font-weight:bold;
    color:#0e2a4d;
    margin:10px 0;
}

.cantidad-actual{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:8px;
    margin:12px 0;
}

.cantidad-actual strong{
    font-size:14px;
}

.cantidad-actual input{
    width:65px;
    padding:8px;
    border:2px solid #63d4f2;
    border-radius:8px;
    text-align:center;
}

.total-final{
    max-width:500px;
    margin:20px auto 30px;
    background:#0e2a4d;
    color:white;
    padding:20px;
    border-radius:18px;
    text-align:center;
    box-shadow:0 8px 20px rgba(14,42,77,.2);
}

.total-final div{
    font-size:16px;
    margin-bottom:5px;
}

.total-final span{
    color:#7be0c4;
    font-size:28px;
    font-weight:bold;
}

.botones-finales{
    display:flex;
    justify-content:center;
    gap:15px;
    margin-top:25px;
}

.botones-finales a{
    text-decoration:none;
}

.btn-final{
    width:auto;
    min-width:200px;
    padding:14px 25px;
}

.btn-nuevo{
    background:#63d4f2;
    color:#0e2a4d;
}

.btn-nuevo:hover{
    background:#7be0c4;
}

.sin-productos{
    grid-column:1/-1;
    text-align:center;
    padding:35px;
    background:#f4fbfd;
    border-radius:18px;
    color:#5b7590;
    font-size:17px;
}

@media(max-width:1200px){
    .productos{
        grid-template-columns:repeat(4,1fr);
    }
}

@media(max-width:950px){
    .productos{
        grid-template-columns:repeat(3,1fr);
    }
}

@media(max-width:650px){

    .contenedor{
        width:92%;
    }

    .productos{
        grid-template-columns:repeat(2,1fr);
        gap:15px;
    }

    .card-img{
        height:180px;
    }

    .encabezado-pedido h1{
        font-size:26px;
    }

    .datos-pedido{
        flex-direction:column;
        gap:8px;
    }

    .botones-finales{
        flex-direction:column;
    }

    .btn-final{
        width:100%;
    }
}

@media(max-width:430px){
    .productos{
        grid-template-columns:1fr;
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

    <div class="encabezado-pedido">

        <h1>Mi Carrito</h1>

        <div class="datos-pedido">

            <div class="dato">
                <strong>Pedido:</strong>
                #<?php echo $idPedido; ?>
            </div>

            <div class="dato">
                <strong>Cliente:</strong>
                <?php echo $datoPedido['nombre']; ?>
            </div>

            <div class="dato">
                <strong>Total:</strong>
                Bs. <span id="totalEncabezado"><?php echo $total; ?></span>
            </div>

        </div>

    </div>


    <div class="titulo-seccion">

        <h2>Productos disponibles</h2>

        <p>Elige los productos que deseas agregar al pedido</p>

    </div>


    <section class="productos">

        <?php if($productos->num_rows > 0){ ?>

            <?php while($fila=$productos->fetch_assoc()){ ?>

                <?php

                if(!empty($fila['imagen'])){
                    $imagenProducto=$fila['imagen'];
                }else{
                    $imagenProducto=$imagenGenerica;
                }

                ?>

                <div class="card">

                    <div
                        class="card-img"
                        style="background-image:url('<?php echo $imagenProducto; ?>')">
                    </div>

                    <div class="card-info">

                        <p class="text-title">
                            <?php echo $fila['nombre']; ?>
                        </p>

                        <p class="text-price">
                            Bs. <?php echo $fila['precio']; ?>
                        </p>

                        <p class="text-body">
                            <?php echo $fila['descripcion']; ?>
                        </p>

                        <p class="stock">
                            Stock: <?php echo $fila['stock']; ?>
                        </p>

                        <form
                            class="form-agregar">

                            <input
                                type="hidden"
                                name="idProducto"
                                value="<?php echo $fila['id']; ?>">

                            <input
                                type="hidden"
                                name="idPedido"
                                value="<?php echo $idPedido; ?>">

                            <div class="cantidad">

                                <label>Cantidad:</label>

                                <input
                                    type="number"
                                    name="cantidad"
                                    min="1"
                                    max="<?php echo $fila['stock']; ?>"
                                    value="1"
                                    required>

                            </div>

                            <button
                                type="submit"
                                class="btn">

                                Agregar

                            </button>

                        </form>

                    </div>

                </div>

            <?php } ?>

        <?php }else{ ?>

            <div class="sin-productos">
                No hay productos registrados.
            </div>

        <?php } ?>

    </section>


    <div class="titulo-seccion">

        <h2>Productos agregados</h2>

        <p>Productos que forman parte de este pedido</p>

    </div>


    <section
        class="productos"
        id="productosCarrito">

        <?php if($detalle->num_rows > 0){ ?>

            <?php while($fila=$detalle->fetch_assoc()){ ?>

                <?php

                if(!empty($fila['imagen'])){
                    $imagenProducto=$fila['imagen'];
                }else{
                    $imagenProducto=$imagenGenerica;
                }

                ?>

                <div
                    class="card card-carrito"
                    id="carrito-<?php echo $fila['productos_id']; ?>">

                    <div
                        class="card-img"
                        style="background-image:url('<?php echo $imagenProducto; ?>')">
                    </div>

                    <div class="card-info">

                        <p class="text-title">
                            <?php echo $fila['nombre']; ?>
                        </p>

                        <p class="text-price">
                            Bs. <?php echo $fila['precio']; ?> c/u
                        </p>

                        <p class="subtotal">
                            Subtotal:
                            Bs.
                            <span class="subtotal-valor">
                                <?php echo $fila['costototal']; ?>
                            </span>
                        </p>

                        <form
                            class="form-actualizar">

                            <input
                                type="hidden"
                                name="idPedido"
                                value="<?php echo $idPedido; ?>">

                            <input
                                type="hidden"
                                name="idProducto"
                                value="<?php echo $fila['productos_id']; ?>">

                            <div class="cantidad-actual">

                                <strong>Cantidad:</strong>

                                <input
                                    type="number"
                                    name="cantidad"
                                    min="1"
                                    max="<?php echo $fila['stock']; ?>"
                                    value="<?php echo $fila['cantidad']; ?>">

                            </div>

                            <button
                                type="submit"
                                class="btn">

                                Actualizar

                            </button>

                        </form>

                        <br>

                        <button
                            type="button"
                            class="btn btn-eliminar"
                            onclick="eliminarProducto(<?php echo $fila['productos_id']; ?>)">

                            Eliminar

                        </button>

                    </div>

                </div>

            <?php } ?>

        <?php }else{ ?>

            <div
                class="sin-productos"
                id="sinProductos">

                Todavía no agregó productos al carrito.

            </div>

        <?php } ?>

    </section>


    <div class="total-final">

        <div>Total del pedido</div>

        <span id="totalFinal">
            Bs. <?php echo $total; ?>
        </span>

    </div>


<div class="botones-finales">

    <button type="button" class="btn btn-final" onclick="mostrarMensaje()">
        Mostrar mensaje
    </button>

    <a href="pedidos/pedidos.php">
        <button onclick="pedidoterminado()" class="btn btn-final">Terminar pedido</button>
    </a>

    <a href="pedidos/formpedido.php">
        <button class="btn btn-final btn-nuevo">Nuevo pedido</button>
    </a>

</div>


<?php include("paginaprincipal/piedepagina.php"); ?>


<script>

const idPedido = <?php echo $idPedido; ?>;
const imagenGenerica = "imagenesproyecto/logo.png";

function escaparHtml(texto){
    return String(texto).replace(/[&<>"']/g, function(c){
        return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c];
    });
}

function dibujarCarrito(items){
    const seccion = document.getElementById("productosCarrito");

    if(!items || items.length === 0){
        seccion.innerHTML = '<div class="sin-productos" id="sinProductos">Todavía no agregó productos al carrito.</div>';
        return;
    }

    let html = "";

    items.forEach(function(item){
        const imagen = (item.imagen && item.imagen.trim() !== "") ? item.imagen : imagenGenerica;

        html += `
        <div class="card card-carrito" id="carrito-${item.productos_id}">
            <div class="card-img" style="background-image:url('${escaparHtml(imagen)}')"></div>
            <div class="card-info">
                <p class="text-title">${escaparHtml(item.nombre)}</p>
                <p class="text-price">Bs. ${item.precio} c/u</p>
                <p class="subtotal">Subtotal: Bs. <span class="subtotal-valor">${item.costototal}</span></p>
                <form class="form-actualizar">
                    <input type="hidden" name="idPedido" value="${idPedido}">
                    <input type="hidden" name="idProducto" value="${item.productos_id}">
                    <div class="cantidad-actual">
                        <strong>Cantidad:</strong>
                        <input type="number" name="cantidad" min="1" max="${item.stock}" value="${item.cantidad}">
                    </div>
                    <button type="submit" class="btn">Actualizar</button>
                </form>
                <br>
                <button type="button" class="btn btn-eliminar" onclick="eliminarProducto(${item.productos_id})">Eliminar</button>
            </div>
        </div>`;
    });

    seccion.innerHTML = html;
}

function refrescarCarrito(){
    fetch("carrito/obtenerCarritoAjax.php?idPedido="+idPedido)
    .then(response => response.json())
    .then(data => {
        if(!data.ok){ return; }
        dibujarCarrito(data.items);
        document.getElementById("totalFinal").textContent = "Bs. "+data.total;
        document.getElementById("totalEncabezado").textContent = data.total;
    })
    .catch(error => console.log(error));
}

document.querySelectorAll(".form-agregar").forEach(function(form){
    form.addEventListener("submit",function(e){
        e.preventDefault();

        const boton = form.querySelector("button");
        const textoOriginal = boton.textContent;
        boton.disabled = true;
        boton.textContent = "Agregando...";

        fetch("agregarCarrito.php",{ method:"POST", body:new FormData(form) })
        .then(response => response.json())
        .then(data => {
            if(data.ok){
                refrescarCarrito();
            }else{
                alert(data.mensaje || "No se pudo agregar el producto");
            }
        })
        .catch(error => {
            console.log(error);
            alert("Ocurrió un error al agregar el producto");
        })
        .finally(function(){
            boton.disabled = false;
            boton.textContent = textoOriginal;
        });
    });
});

document.getElementById("productosCarrito").addEventListener("submit", function(e){
    if(!e.target.classList.contains("form-actualizar")){ return; }
    e.preventDefault();

    const form = e.target;
    const boton = form.querySelector("button");
    const textoOriginal = boton.textContent;
    boton.disabled = true;
    boton.textContent = "Actualizando...";

    fetch("carrito/actualizarCarrito.php",{ method:"POST", body:new FormData(form) })
    .then(response => response.json())
    .then(data => {
        if(data.ok){
            refrescarCarrito();
        }else{
            alert(data.mensaje || "No se pudo actualizar la cantidad");
            boton.disabled = false;
            boton.textContent = textoOriginal;
        }
    })
    .catch(error => {
        console.log(error);
        alert("Ocurrió un error al actualizar");
        boton.disabled = false;
        boton.textContent = textoOriginal;
    });
});

// ELIMINAR
function eliminarProducto(idProducto){
    if(!confirm("¿Deseas eliminar este producto del carrito?")){ return; }

    const datos = new FormData();
    datos.append("idPedido", idPedido);
    datos.append("idProducto", idProducto);

    fetch("eliminarCarrito.php",{ method:"POST", body:datos })
    .then(response => response.json())
    .then(data => {
        if(data.ok){
            refrescarCarrito();
        }else{
            alert(data.mensaje || "No se pudo eliminar el producto");
        }
    })
    .catch(error => {
        console.log(error);
        alert("Ocurrió un error al eliminar");
    });
}

function pedidoterminado(){
    alert("Tu pedido se registro!");
}
Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#6491bb",
  cancelButtonColor: "rgba(3, 2, 75, 0.62)",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) Swal.fire({
    title: "Deleted!",
    text: "Your file has been deleted.",
    icon: "success"
  });
});
</script>

</body>
</html>