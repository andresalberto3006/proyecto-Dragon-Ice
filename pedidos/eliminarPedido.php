<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: ../iniciosesion.php");
    exit();
}

if ($_SESSION['rol'] != 'Vendedor' && $_SESSION['rol'] != 'Administrador') {
    header("Location: ../iniciosesion.php");
    exit();
}

include("../conexion.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($_SESSION['rol'] == 'Administrador') {
    $sqlPedido = "SELECT * FROM pedidos WHERE id='$id'";
} else {
    $ci = $_SESSION['ci'];
    $sqlPedido = "SELECT * FROM pedidos WHERE id='$id' AND vendedor_ci='$ci'";
}

$resultadoPedido = $conexion->query($sqlPedido);

if ($resultadoPedido->num_rows == 0) {
    header("Location: pedidos.php");
    exit();
}

$pedido = $resultadoPedido->fetch_assoc();

if ($pedido['estado'] != 'Rechazado') {
    echo '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        icon: "warning",
        title: "No se puede eliminar",
        text: "Solo se pueden eliminar pedidos rechazados. Si el cliente canceló, primero rechaza el pedido.",
        confirmButtonText: "Entendido",
        confirmButtonColor: "#0e2a4d"
    }).then(function(){
        window.location = "pedidos.php";
    });
</script>
</body>
</html>';
    exit();
}

$conexion->query("DELETE FROM carrito WHERE pedidos_id='$id'");
$conexion->query("DELETE FROM pedidos WHERE id='$id'");

header("Location: pedidos.php");
exit();
?>