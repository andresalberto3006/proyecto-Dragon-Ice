<?php
// conexion.php (inclúyelo o pega esto arriba del archivo)
$conn = new mysqli('localhost', 'root', '', 'dragonice');
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

$result = $conn->query("SELECT id, nombre, descripcion, precio, stock, imagen FROM productos");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="carrito.css">
</head>

<body>

    <!--================== CABECERA ==================-->
    <header>
        <div class="logo">
            🛍 <span>MI TIENDA</span>
        </div>

        <div class="busqueda">
            <input type="text" id="buscar" placeholder="Buscar producto...">
        </div>

        <div id="carritoIcono">
            🛒 <span id="cantidadCarrito">0</span>
        </div>
    </header>

    <!--================== PRODUCTOS ==================-->
    <main>
        <h2 class="titulo">Productos Disponibles</h2>

        <section id="productos">
            <?php while ($fila = $result->fetch_assoc()): ?>
                <div class="producto"
                     data-id="<?php echo $fila['id']; ?>"
                     data-nombre="<?php echo htmlspecialchars($fila['nombre']); ?>"
                     data-precio="<?php echo $fila['precio']; ?>"
                     data-stock="<?php echo $fila['stock']; ?>">

                    <img src="<?php echo htmlspecialchars($fila['imagen']); ?>"
                         alt="<?php echo htmlspecialchars($fila['nombre']); ?>">

                    <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                    <p><?php echo htmlspecialchars($fila['descripcion']); ?></p>
                    <p class="precio">Bs <?php echo number_format($fila['precio'], 2); ?></p>

                    <?php if ($fila['stock'] > 0): ?>
                        <button class="btn-agregar"
                                data-id="<?php echo $fila['id']; ?>">
                            Agregar al carrito
                        </button>
                    <?php else: ?>
                        <button class="btn-agregar" disabled>Sin stock</button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </section>
    </main>

    <button id="generarPedido">Generar Pedido</button>

    <div id="formularioPedido" style="display:none">
        <h2>Datos del cliente</h2>

        <input type="text" id="nombre" placeholder="Nombre">
        <input type="text" id="telefono" placeholder="Teléfono">
        <input type="text" id="direccion" placeholder="Dirección">

        <select id="pago">
            <option value="QR">QR</option>
            <option value="Efectivo">Efectivo</option>
        </select>

        <button id="btnRegistrarPedido">Registrar Pedido</button>
    </div>

    <!--================== FONDO OSCURO ==================-->
    <div id="fondo"></div>

    <!--================== SIDEBAR ==================-->
    <aside id="sidebar">
        <div class="sidebarHeader">
            <h2>🛒 Mi Carrito</h2>
            <button id="cerrarCarrito">✖</button>
        </div>

        <div id="contenidoCarrito"></div>

        <div class="sidebarFooter">
            <h3 id="totalCarrito">Total: Bs 0</h3>
            <button id="vaciarCarrito">Vaciar carrito</button>
            <button id="comprar">Comprar</button>
        </div>
    </aside>

    <script src="carrito.js"></script>
</body>

</html>