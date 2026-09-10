<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: ../iniciosesion.php");
    exit();
}

if ($_SESSION['rol'] != 'Administrador') {
    header("Location: ../paginaprincipal/vendedor20.php");
    exit();
}

include("../conexion.php");

/* ---------- Tarjetas de resumen ---------- */

$hoy = $conexion->query("
    SELECT COUNT(*) AS cantidad, IFNULL(SUM(total),0) AS total
    FROM ventas
    WHERE fecha = CURDATE()
")->fetch_assoc();

$semana = $conexion->query("
    SELECT COUNT(*) AS cantidad, IFNULL(SUM(total),0) AS total
    FROM ventas
    WHERE YEARWEEK(fecha,1) = YEARWEEK(CURDATE(),1)
")->fetch_assoc();

$mes = $conexion->query("
    SELECT COUNT(*) AS cantidad, IFNULL(SUM(total),0) AS total
    FROM ventas
    WHERE MONTH(fecha) = MONTH(CURDATE()) AND YEAR(fecha) = YEAR(CURDATE())
")->fetch_assoc();

$anio = $conexion->query("
    SELECT COUNT(*) AS cantidad, IFNULL(SUM(total),0) AS total
    FROM ventas
    WHERE YEAR(fecha) = YEAR(CURDATE())
")->fetch_assoc();

/* ---------- Gráfico: ventas de los últimos 7 días ---------- */

$grafico = $conexion->query("
    SELECT fecha, IFNULL(SUM(total),0) AS total
    FROM ventas
    WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY fecha
    ORDER BY fecha ASC
");

$fechasGrafico = [];
$totalesGrafico = [];

while ($fila = $grafico->fetch_assoc()) {
    $fechasGrafico[] = date("d/m", strtotime($fila['fecha']));
    $totalesGrafico[] = (float)$fila['total'];
}

/* ---------- Productos más vendidos (top 5) ---------- */

$productos = $conexion->query("
    SELECT p.nombre, SUM(c.cantidad) AS cantidad
    FROM carrito c
    INNER JOIN productos p ON c.productos_id = p.id
    INNER JOIN ventas v ON c.pedidos_id = v.pedidos_id
    GROUP BY p.id, p.nombre
    ORDER BY cantidad DESC
    LIMIT 5
");

$nombresProductos = [];
$cantidadesProductos = [];

while ($fila = $productos->fetch_assoc()) {
    $nombresProductos[] = $fila['nombre'];
    $cantidadesProductos[] = (int)$fila['cantidad'];
}

/* ---------- Clientes que más han comprado (top 5) ---------- */

$clientes = $conexion->query("
    SELECT cliente, COUNT(*) AS compras, SUM(total) AS totalComprado
    FROM ventas
    GROUP BY cliente
    ORDER BY totalComprado DESC
    LIMIT 5
");

$nombresClientes = [];
$totalesClientes = [];

while ($fila = $clientes->fetch_assoc()) {
    $nombresClientes[] = $fila['cliente'];
    $totalesClientes[] = (float)$fila['totalComprado'];
}

$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reporte de Ventas | Dragon Ice</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f5f9fd;
    color:#0e2a4d;
}

.contenedor{
    max-width:1200px;
    margin:0 auto;
    padding:30px 24px 60px;
}

h1{
    text-align:center;
    color:#0e2a4d;
    margin-bottom:30px;
}

.tarjetas{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;
}

.tarjeta{
    background:#ffffff;
    border:1px solid #dcecf3;
    border-radius:12px;
    padding:22px;
    text-align:center;
}

.tarjeta .etiqueta{
    font-size:13px;
    color:#5b7590;
    font-weight:bold;
    text-transform:uppercase;
    letter-spacing:.5px;
    margin-bottom:10px;
}

.tarjeta .monto{
    font-size:24px;
    font-weight:bold;
    color:#0e2a4d;
    margin-bottom:6px;
}

.tarjeta .cantidad{
    font-size:13px;
    color:#159db9;
    font-weight:bold;
}

.paneles{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

.panel{
    background:#ffffff;
    border:1px solid #dcecf3;
    border-radius:12px;
    padding:22px;
    margin-bottom:25px;
}

.panel h2{
    font-size:17px;
    color:#0e2a4d;
    margin-bottom:18px;
    padding-bottom:10px;
    border-bottom:3px solid #63d4f2;
}

.panel-ancho{
    grid-column:1 / -1;
}

.sin-datos{
    text-align:center;
    color:#5b7590;
    padding:30px;
}

.volver{
    display:block;
    width:250px;
    margin:10px auto 0;
    text-align:center;
    text-decoration:none;
    background:#0e2a4d;
    color:white;
    padding:15px;
    border-radius:10px;
    font-weight:bold;
}

.volver:hover{
    background:#173a8a;
}

@media(max-width:900px){
    .tarjetas{ grid-template-columns:1fr 1fr; }
    .paneles{ grid-template-columns:1fr; }
}

@media(max-width:500px){
    .tarjetas{ grid-template-columns:1fr; }
}

</style>
</head>
<body>

<?php include("../menu.php"); ?>

<main class="contenedor">

    <h1>Reporte de Ventas</h1>

    <section class="tarjetas">

        <div class="tarjeta">
            <div class="etiqueta">Ventas del día</div>
            <div class="monto">Bs. <?php echo number_format($hoy['total'],2); ?></div>
            <div class="cantidad"><?php echo $hoy['cantidad']; ?> venta(s)</div>
        </div>

        <div class="tarjeta">
            <div class="etiqueta">Ventas de la semana</div>
            <div class="monto">Bs. <?php echo number_format($semana['total'],2); ?></div>
            <div class="cantidad"><?php echo $semana['cantidad']; ?> venta(s)</div>
        </div>

        <div class="tarjeta">
            <div class="etiqueta">Ventas del mes</div>
            <div class="monto">Bs. <?php echo number_format($mes['total'],2); ?></div>
            <div class="cantidad"><?php echo $mes['cantidad']; ?> venta(s)</div>
        </div>

        <div class="tarjeta">
            <div class="etiqueta">Ventas del año</div>
            <div class="monto">Bs. <?php echo number_format($anio['total'],2); ?></div>
            <div class="cantidad"><?php echo $anio['cantidad']; ?> venta(s)</div>
        </div>

    </section>

    <section class="paneles">

        <div class="panel panel-ancho">
            <h2>Ventas de los últimos 7 días</h2>
            <?php if (count($fechasGrafico) > 0) { ?>
                <canvas id="graficoVentas" height="90"></canvas>
            <?php } else { ?>
                <p class="sin-datos">Todavía no hay ventas registradas.</p>
            <?php } ?>
        </div>

        <div class="panel">
            <h2>Productos más vendidos</h2>
            <?php if (count($nombresProductos) > 0) { ?>
                <canvas id="graficoProductos"></canvas>
            <?php } else { ?>
                <p class="sin-datos">Todavía no hay productos vendidos.</p>
            <?php } ?>
        </div>

        <div class="panel">
            <h2>Clientes que más compran</h2>
            <?php if (count($nombresClientes) > 0) { ?>
                <canvas id="graficoClientes"></canvas>
            <?php } else { ?>
                <p class="sin-datos">Todavía no hay clientes registrados.</p>
            <?php } ?>
        </div>

    </section>

    <a href="../paginaprincipal/02.admin.php" class="volver">Volver al panel</a>

</main>

<?php include("../paginaprincipal/piedepagina.php"); ?>

<script>

const fechasGrafico = <?php echo json_encode($fechasGrafico); ?>;
const totalesGrafico = <?php echo json_encode($totalesGrafico); ?>;

const nombresProductos = <?php echo json_encode($nombresProductos); ?>;
const cantidadesProductos = <?php echo json_encode($cantidadesProductos); ?>;

const nombresClientes = <?php echo json_encode($nombresClientes); ?>;
const totalesClientes = <?php echo json_encode($totalesClientes); ?>;

if (fechasGrafico.length > 0) {
    new Chart(document.getElementById("graficoVentas"), {
        type: "line",
        data: {
            labels: fechasGrafico,
            datasets: [{
                label: "Ventas en Bs.",
                data: totalesGrafico,
                borderColor: "#159db9",
                backgroundColor: "rgba(99,212,242,0.25)",
                borderWidth: 3,
                tension: 0.2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
}

if (nombresProductos.length > 0) {
    new Chart(document.getElementById("graficoProductos"), {
        type: "bar",
        data: {
            labels: nombresProductos,
            datasets: [{
                label: "Cantidad vendida",
                data: cantidadesProductos,
                backgroundColor: "#63d4f2",
                borderColor: "#0e2a4d",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
}

if (nombresClientes.length > 0) {
    new Chart(document.getElementById("graficoClientes"), {
        type: "bar",
        data: {
            labels: nombresClientes,
            datasets: [{
                label: "Total comprado en Bs.",
                data: totalesClientes,
                backgroundColor: "#7be0c4",
                borderColor: "#0e2a4d",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: "y",
            plugins: { legend: { display: false } },
            scales: { x: { beginAtZero: true } }
        }
    });
}

</script>

</body>
</html>