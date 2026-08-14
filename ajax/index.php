
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catalogo</title>

    <link rel="stylesheet" href="css/estilos.css">

</head>

<body>

    <!--================== CABECERA ==================-->

    <header>

        <div class="logo">

            🛍 <span>MI TIENDA</span>

        </div>

        <div class="busqueda">

            <input
                type="text"
                id="buscar"
                placeholder="Buscar producto...">

        </div>

        <div id="carritoIcono">

            🛒 <span id="cantidadCarrito">0</span>

        </div>

    </header>

    <!--================== PRODUCTOS ==================-->

    <main>

        <h2 class="titulo">
            Productos Disponibles
        </h2>

        <section id="productos">

        </section>

    </main>
    
   <button id="generarPedido">
Generar Pedido
</button>
<div id="formularioPedido" style="display:none">

    <h2>Datos del cliente</h2>

    <input 
    type="text" 
    id="nombre" 
    placeholder="Nombre">

    <input 
    type="text" 
    id="telefono" 
    placeholder="Teléfono">

    <input 
    type="text" 
    id="direccion" 
    placeholder="Dirección">


    <select id="pago">

        <option value="QR">
            QR
        </option>

        <option value="Efectivo">
            Efectivo
        </option>

    </select>


    <button id="btnRegistrarPedido">
        Registrar Pedido
    </button>

</div>
<!--================== FONDO OSCURO ==================-->

    <div id="fondo"></div>

    <!--================== SIDEBAR ==================-->

    <aside id="sidebar">

        <div class="sidebarHeader">

            <h2>🛒 Mi Carrito</h2>

            <button id="cerrarCarrito">✖</button>

        </div>

        <div id="contenidoCarrito">

        </div>

        <div class="sidebarFooter">

            <h3 id="totalCarrito">

                Total: Bs 0

            </h3>

            <button id="vaciarCarrito">

                Vaciar carrito

            </button>

            <button id="comprar">

                Comprar

            </button>

        </div>

    </aside>
 



    


<script src="js/productos.php"></script>
<script src="js/carrito"></script>
</body>

</html>