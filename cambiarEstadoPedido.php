<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: iniciosesion.php");
    exit();
}

if ($_SESSION['rol'] != 'Vendedor') {
    header("Location: paginaprincipal/02.admin.php");
    exit();
}

include("conexion.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';
$ci = $_SESSION['ci'];

if ($estado == 'En proceso' || $estado == 'Rechazado') {

    if ($estado == 'En proceso') {
        $sqlCantidad = "SELECT COUNT(*) AS total
                        FROM carrito
                        WHERE pedidos_id='$id'";

        $cantidad = $conexion->query($sqlCantidad)->fetch_assoc();

        if ($cantidad['total'] == 0) {
            echo "<script>
                    alert('No se puede aceptar un pedido vacío.');
                    window.location='pedidos.php';
                  </script>";
            exit();
        }
    }

    $sql = "UPDATE pedidos
            SET estado='$estado'
            WHERE id='$id'
            AND vendedor_ci='$ci'
            AND estado='Pendiente'";

    $conexion->query($sql);
}

header("Location: pedidos.php");
exit();
?>