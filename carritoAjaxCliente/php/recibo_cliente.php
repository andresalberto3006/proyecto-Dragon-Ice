<?php
require_once __DIR__ . '/../../conexion.php';

$idPedido = (int)($_GET['idPedido'] ?? 0);

if ($idPedido <= 0) {
    die("Pedido no válido.");
}

$stmt = $conn->prepare(
    "SELECT id, nombre, fecha, estado, metodo_pago
     FROM pedidos
     WHERE id = ?"
);
$stmt->bind_param("i", $idPedido);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();

if (!$pedido) {
    die("Pedido no encontrado.");
}

$stmt = $conn->prepare(
    "SELECT p.nombre, p.precio, c.cantidad, c.costototal
     FROM carrito c
     INNER JOIN productos p ON p.id = c.productos_id
     WHERE c.pedidos_id = ?"
);
$stmt->bind_param("i", $idPedido);
$stmt->execute();
$productos = $stmt->get_result();

$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Comprobante - Dragon Ice</title>
<link rel="stylesheet" href="../css/carrito.css">
</head>
<body>
<div class="recibo">
    <h1>🍦 DRAGON ICE</h1>
    <h2>Comprobante de pedido</h2>

    <p><strong>Pedido:</strong> #<?= (int)$pedido['id'] ?></p>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['nombre']) ?></p>
    <p><strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha']) ?></p>
    <p><strong>Estado:</strong> <?= htmlspecialchars($pedido['estado']) ?></p>
    <p><strong>Método de pago:</strong> <?= htmlspecialchars($pedido['metodo_pago']) ?></p>

    <hr>

    <?php while ($producto = $productos->fetch_assoc()): ?>
        <?php $total += (float)$producto['costototal']; ?>
        <div class="linea-recibo">
            <span>
                <?= htmlspecialchars($producto['nombre']) ?>
                × <?= (int)$producto['cantidad'] ?>
            </span>
            <strong>Bs. <?= number_format($producto['costototal'], 2) ?></strong>
        </div>
    <?php endwhile; ?>

    <h2 class="total">TOTAL: Bs. <?= number_format($total, 2) ?></h2>

    <button onclick="window.print()">🖨️ Imprimir</button>
</div>
</body>
</html>
