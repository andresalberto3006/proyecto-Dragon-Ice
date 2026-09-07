<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: ../iniciosesion.php");
    exit();
}

if ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'Vendedor') {
    header("Location: ../iniciosesion.php");
    exit();
}

include("../conexion.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$r = $conexion->query("SELECT COUNT(*) AS total FROM carrito WHERE productos_id='$id'")->fetch_assoc();

if ($r['total'] > 0) {
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
        text: "El producto pertenece a un pedido existente.",
        confirmButtonText: "Entendido",
        confirmButtonColor: "#0e2a4d"
    }).then(function(){
        window.location = "read.all.producto.php";
    });
</script>
</body>
</html>';
    exit();
}

$eliminado = $conexion->query("DELETE FROM productos WHERE id='$id'");
$errorMensaje = $conexion->error;

header("Location: read.all.producto.php");
exit();
?>