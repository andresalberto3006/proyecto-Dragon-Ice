<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Dragon Ice</title>
    <link rel="stylesheet" href="css/carrito.css">
</head>
<body>

<div class="carrito-contenedor">
    <h1>🛒 Mi carrito</h1>

    <div id="estadoPedido" class="estado">Comprobando pedido...</div>

    <div id="mensaje" class="mensaje"></div>

    <div id="carritoContenido">
        <p>Cargando carrito...</p>
    </div>

    <div class="acciones">
        <button id="btnNuevoPedido" type="button">➕ Nuevo pedido</button>
        <button id="btnComprar" type="button" disabled>🛒 Comprar</button>
    </div>
</div>

<script src="js/pedido_cliente.js"></script>
<script src="js/carrito_cliente.js"></script>
</body>
</html>
