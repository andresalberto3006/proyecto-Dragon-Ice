<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') {
    header("Location: ../iniciarsesion/iniciosesion.php");
    exit();
}

include("../conexion.php");

$archivo = __DIR__ . "/ingresos.json";
$ingresos = array();

if (file_exists($archivo)) {
    $datos = json_decode(file_get_contents($archivo), true);
    if (is_array($datos)) {
        $ingresos = $datos;
    }
}

function guardarIngresos($archivo, $ingresos) {
    file_put_contents($archivo, json_encode(array_values($ingresos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $monto = isset($_POST['monto']) ? floatval($_POST['monto']) : 0;

    $datosValidos = preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha) && $descripcion != '' && $monto > 0;

    if ($accion == 'guardar' && $datosValidos) {

        $mayorId = 0;
        foreach ($ingresos as $ingreso) {
            if ($ingreso['id'] > $mayorId) {
                $mayorId = $ingreso['id'];
            }
        }

        $ingresos[] = array(
            "id" => $mayorId + 1,
            "fecha" => $fecha,
            "descripcion" => $descripcion,
            "monto" => $monto
        );
        guardarIngresos($archivo, $ingresos);

    } elseif ($accion == 'editar' && $datosValidos) {

        foreach ($ingresos as $clave => $ingreso) {
            if ($ingreso['id'] == $id) {
                $ingresos[$clave]['fecha'] = $fecha;
                $ingresos[$clave]['descripcion'] = $descripcion;
                $ingresos[$clave]['monto'] = $monto;
                break;
            }
        }
        guardarIngresos($archivo, $ingresos);

    } elseif ($accion == 'eliminar') {

        foreach ($ingresos as $clave => $ingreso) {
            if ($ingreso['id'] == $id) {
                unset($ingresos[$clave]);
                break;
            }
        }
        guardarIngresos($archivo, $ingresos);
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$todos = $ingresos;

$resultadoVentas = $conn->query("SELECT id, pedidos_id, fecha, cliente, nombrevendedor, total FROM ventas");

if ($resultadoVentas) {
    while ($venta = $resultadoVentas->fetch_assoc()) {
        $todos[] = array(
            "id" => "V-" . $venta['id'],
            "fecha" => $venta['fecha'],
            "descripcion" => "Venta pedido #" . $venta['pedidos_id'] . " · " . $venta['cliente'] . " (" . $venta['nombrevendedor'] . ")",
            "monto" => floatval($venta['total']),
            "pedido" => $venta['pedidos_id']
        );
    }
}

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'todos';
if (!in_array($tipo, array('todos', 'dia', 'semana', 'mes', 'anio'))) {
    $tipo = 'todos';
}

$fechaBase = (isset($_GET['fecha']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['fecha'])) ? $_GET['fecha'] : date('Y-m-d');
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$desde = '';
$hasta = '';
$textoFiltro = 'Todos los ingresos';
$base = new DateTime($fechaBase);

if ($tipo == 'dia') {
    $desde = $fechaBase;
    $hasta = $fechaBase;
    $textoFiltro = 'Ingresos del día';
} elseif ($tipo == 'semana') {
    $inicio = clone $base;
    $inicio->modify('-' . ($base->format('N') - 1) . ' days');
    $fin = clone $inicio;
    $fin->modify('+6 days');
    $desde = $inicio->format('Y-m-d');
    $hasta = $fin->format('Y-m-d');
    $textoFiltro = 'Ingresos de la semana';
} elseif ($tipo == 'mes') {
    $desde = $base->format('Y-m-01');
    $hasta = $base->format('Y-m-t');
    $textoFiltro = 'Ingresos del mes';
} elseif ($tipo == 'anio') {
    $desde = $base->format('Y-01-01');
    $hasta = $base->format('Y-12-31');
    $textoFiltro = 'Ingresos del año';
}

$resultados = array();
foreach ($todos as $ingreso) {
    if ($desde != '' && ($ingreso['fecha'] < $desde || $ingreso['fecha'] > $hasta)) {
        continue;
    }
    if ($buscar != '' && stripos($ingreso['descripcion'], $buscar) === false) {
        continue;
    }
    $resultados[] = $ingreso;
}

usort($resultados, function ($a, $b) {
    return strcmp($b['fecha'], $a['fecha']);
});

$total = 0;
$porFecha = array();
foreach ($resultados as $ingreso) {
    $total += $ingreso['monto'];
    if (!isset($porFecha[$ingreso['fecha']])) {
        $porFecha[$ingreso['fecha']] = 0;
    }
    $porFecha[$ingreso['fecha']] += $ingreso['monto'];
}
ksort($porFecha);

$sqlTop = "SELECT productos.nombre, SUM(carrito.cantidad) AS cantidad
           FROM carrito
           INNER JOIN productos ON carrito.productos_id = productos.id
           INNER JOIN ventas ON carrito.pedidos_id = ventas.pedidos_id
           GROUP BY productos.id, productos.nombre
           ORDER BY cantidad DESC
           LIMIT 3";

$resultadoTop = $conn->query($sqlTop);
$topNombres = array();
$topCantidades = array();

if ($resultadoTop) {
    while ($fila = $resultadoTop->fetch_assoc()) {
        $topNombres[] = $fila['nombre'];
        $topCantidades[] = intval($fila['cantidad']);
    }
}

$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reporte de Ingresos | Dragon Ice</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

:root{
    --azul-oscuro:#0e2a4d;
    --azul-medio:#2f5d9f;
    --celeste:#29a8e0;
    --menta:#7be0c4;
    --gris-texto:#5b7590;
    --borde:#c9dcee;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

html, body{
    height:100%;
}

body{
    display:flex;
    flex-direction:column;
    min-height:100vh;
}

.fondo-panel{
    flex:1;
    background:#2f5d9f;
    padding:40px 20px;
    display:flex;
    justify-content:center;
    align-items:flex-start;
}

.contenedor{
    width:100%;
    max-width:1150px;
    background:#e3eef9;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

.titulo{
    text-align:center;
    margin-bottom:25px;
}

.titulo h1{
    font-size:30px;
    color:var(--azul-oscuro);
}

.titulo p{
    margin-top:6px;
    color:var(--gris-texto);
}

.tarjeta{
    background:white;
    border:1px solid var(--borde);
    border-radius:14px;
    padding:22px;
    margin-bottom:20px;
}

.tarjeta h2{
    font-size:19px;
    color:var(--azul-oscuro);
    margin-bottom:16px;
    padding-bottom:10px;
    border-bottom:3px solid #4da6ff;
    display:inline-block;
}

input, select{
    width:100%;
    padding:11px;
    border:1px solid var(--borde);
    border-radius:10px;
    font-size:15px;
    color:var(--azul-oscuro);
    background:#f4f8ff;
    outline:none;
}

input:focus, select:focus{
    border-color:var(--celeste);
    background:white;
}

.boton{
    display:inline-block;
    border:none;
    border-radius:10px;
    padding:11px 20px;
    font-size:14px;
    font-weight:bold;
    color:white;
    background:var(--azul-oscuro);
    text-decoration:none;
    text-align:center;
    cursor:pointer;
    transition:.25s;
}

.boton:hover{
    background:var(--celeste);
}

.boton.editar{
    background:#28a745;
    padding:8px 14px;
}

.boton.editar:hover{
    background:#1e7e34;
}

.boton.eliminar{
    background:#dc3545;
    padding:8px 14px;
}

.boton.eliminar:hover{
    background:#a71d2a;
}

.boton.ver{
    background:#4da6ff;
    padding:8px 14px;
}

.boton.ver:hover{
    background:var(--azul-medio);
}

.boton.claro{
    background:#e3eef9;
    color:var(--azul-oscuro);
    border:1px solid var(--borde);
}

.boton.claro:hover{
    background:var(--menta);
}

.fila-nuevo{
    display:grid;
    grid-template-columns:1fr 2fr 1fr auto;
    gap:12px;
}

.fila-filtros{
    display:grid;
    grid-template-columns:1fr 1fr 2fr auto auto;
    gap:12px;
}

.resumen{
    background:var(--azul-oscuro);
    border-radius:14px;
    padding:24px;
    text-align:center;
    margin-bottom:20px;
}

.resumen .monto-total{
    font-size:34px;
    font-weight:bold;
    color:white;
}

.resumen .detalle{
    margin-top:6px;
    color:#c7ddec;
    font-size:14px;
}

.graficos{
    display:grid;
    grid-template-columns:3fr 2fr;
    gap:20px;
}

.grafico{
    position:relative;
    height:300px;
}

.vacio{
    text-align:center;
    color:var(--gris-texto);
    padding:40px 10px;
}

.tabla-scroll{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:var(--azul-oscuro);
    color:white;
    padding:14px;
    text-align:center;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #dde8f3;
    color:var(--azul-oscuro);
}

tr:nth-child(even) td{
    background:#f4f8ff;
}

tr:hover td{
    background:#dcecf8;
}

td.monto{
    font-weight:bold;
}

.acciones{
    display:flex;
    justify-content:center;
    gap:8px;
}

.acciones form{
    margin:0;
}

.di-modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    align-items:center;
    justify-content:center;
    padding:20px;
    z-index:2000;
}

.di-modal.activo{
    display:flex;
}

.di-modal-caja{
    width:100%;
    max-width:450px;
    background:white;
    padding:30px;
    border-radius:20px;
}

.di-modal-caja h2{
    color:var(--azul-oscuro);
}

.di-modal-caja label{
    display:block;
    margin:14px 0 5px;
    font-weight:bold;
    font-size:14px;
    color:var(--azul-oscuro);
}

.botones-modal{
    display:flex;
    gap:10px;
    margin-top:22px;
}

.botones-modal .boton{
    flex:1;
}

.swal2-container{
    z-index:3000 !important;
}

@media(max-width:900px){
    .contenedor{ padding:18px; }
    .fila-nuevo, .fila-filtros, .graficos{
        grid-template-columns:1fr;
    }
}

</style>
</head>
<body>

<?php include("../paginaprincipal/menu.php"); ?>

<main class="fondo-panel">
<div class="contenedor">

    <div class="titulo">
        <h1>Reporte de Ingresos</h1>
        <p>Dragon Ice</p>
    </div>

    <div class="tarjeta">
        <h2>Registrar nuevo ingreso</h2>
        <form method="POST" class="fila-nuevo">
            <input type="hidden" name="accion" value="guardar">
            <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
            <input type="text" name="descripcion" placeholder="Descripción del ingreso" maxlength="150" required>
            <input type="number" name="monto" placeholder="Monto en Bs." step="0.01" min="0.01" required>
            <button type="submit" class="boton">Guardar</button>
        </form>
    </div>

    <div class="tarjeta">
        <h2>Filtrar ingresos</h2>
        <form method="GET" class="fila-filtros">
            <select name="tipo" id="tipo">
                <option value="todos" <?php echo $tipo == 'todos' ? 'selected' : ''; ?>>Todos</option>
                <option value="dia" <?php echo $tipo == 'dia' ? 'selected' : ''; ?>>Por día</option>
                <option value="semana" <?php echo $tipo == 'semana' ? 'selected' : ''; ?>>Por semana</option>
                <option value="mes" <?php echo $tipo == 'mes' ? 'selected' : ''; ?>>Por mes</option>
                <option value="anio" <?php echo $tipo == 'anio' ? 'selected' : ''; ?>>Por año</option>
            </select>
            <input type="date" name="fecha" id="fecha" value="<?php echo htmlspecialchars($fechaBase); ?>">
            <input type="text" name="buscar" placeholder="Buscar por descripción..." value="<?php echo htmlspecialchars($buscar); ?>">
            <button type="submit" class="boton">Filtrar</button>
            <a href="ingre-total.php" class="boton claro">Limpiar</a>
        </form>
    </div>

    <div class="resumen">
        <div class="monto-total">Bs. <?php echo number_format($total, 2); ?></div>
        <div class="detalle">
            <?php echo $textoFiltro; ?>
            <?php echo $buscar != '' ? ' · búsqueda: "' . htmlspecialchars($buscar) . '"' : ''; ?>
            · <?php echo count($resultados); ?> registro(s)
        </div>
    </div>

    <div class="graficos">

        <div class="tarjeta">
            <h2>Evolución de ingresos</h2>
            <?php if (count($porFecha) > 0) { ?>
                <div class="grafico"><canvas id="graficoIngresos"></canvas></div>
            <?php } else { ?>
                <p class="vacio">No hay ingresos para graficar.</p>
            <?php } ?>
        </div>

        <div class="tarjeta">
            <h2>Top 3 productos más vendidos</h2>
            <?php if (count($topNombres) > 0) { ?>
                <div class="grafico"><canvas id="graficoProductos"></canvas></div>
            <?php } else { ?>
                <p class="vacio">Aún no hay ventas registradas.</p>
            <?php } ?>
        </div>

    </div>

    <div class="tarjeta">
        <h2>Detalle de ingresos</h2>

        <?php if (count($resultados) > 0) { ?>
        <div class="tabla-scroll">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($resultados as $ingreso) { ?>
                <tr>
                    <td><?php echo $ingreso['id']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($ingreso['fecha'])); ?></td>
                    <td><?php echo htmlspecialchars($ingreso['descripcion']); ?></td>
                    <td class="monto">Bs. <?php echo number_format($ingreso['monto'], 2); ?></td>
                    <td>
                        <div class="acciones">
                            <?php if (isset($ingreso['pedido'])) { ?>

                                <a class="boton ver" href="../pedidos/detallePedido.php?id=<?php echo $ingreso['pedido']; ?>">Ver venta</a>

                            <?php } else { ?>

                                <button type="button" class="boton editar"
                                    data-id="<?php echo $ingreso['id']; ?>"
                                    data-fecha="<?php echo htmlspecialchars($ingreso['fecha']); ?>"
                                    data-descripcion="<?php echo htmlspecialchars($ingreso['descripcion']); ?>"
                                    data-monto="<?php echo $ingreso['monto']; ?>">Editar</button>

                                <form method="POST" class="form-eliminar">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id" value="<?php echo $ingreso['id']; ?>">
                                    <button type="submit" class="boton eliminar">Eliminar</button>
                                </form>

                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php } else { ?>
            <p class="vacio">No hay ingresos registrados para este período.</p>
        <?php } ?>
    </div>

</div>
</main>

<div class="di-modal" id="modalEditar">
    <div class="di-modal-caja">
        <h2>Editar ingreso</h2>
        <form method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id" id="editarId">

            <label>Fecha</label>
            <input type="date" name="fecha" id="editarFecha" required>

            <label>Descripción</label>
            <input type="text" name="descripcion" id="editarDescripcion" maxlength="150" required>

            <label>Monto en Bs.</label>
            <input type="number" name="monto" id="editarMonto" step="0.01" min="0.01" required>

            <div class="botones-modal">
                <button type="button" class="boton claro" id="cancelarEditar">Cancelar</button>
                <button type="submit" class="boton">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<?php include("../paginaprincipal/piedepagina.php"); ?>

<script>

var modal = document.getElementById("modalEditar");

document.querySelectorAll(".boton.editar").forEach(function(boton){
    boton.addEventListener("click", function(){
        document.getElementById("editarId").value = boton.dataset.id;
        document.getElementById("editarFecha").value = boton.dataset.fecha;
        document.getElementById("editarDescripcion").value = boton.dataset.descripcion;
        document.getElementById("editarMonto").value = boton.dataset.monto;
        modal.classList.add("activo");
    });
});

document.getElementById("cancelarEditar").addEventListener("click", function(){
    modal.classList.remove("activo");
});

modal.addEventListener("click", function(e){
    if(e.target === modal){
        modal.classList.remove("activo");
    }
});

document.querySelectorAll(".form-eliminar").forEach(function(form){
    form.addEventListener("submit", function(e){
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "¿Eliminar ingreso?",
            text: "Esta acción no se puede deshacer.",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#0e2a4d"
        }).then(function(resultado){
            if(resultado.isConfirmed){
                form.submit();
            }
        });
    });
});

var tipo = document.getElementById("tipo");
var fecha = document.getElementById("fecha");

function revisarFecha(){
    fecha.disabled = (tipo.value === "todos");
}

tipo.addEventListener("change", revisarFecha);
revisarFecha();

Chart.defaults.font.family = "Arial, Helvetica, sans-serif";
Chart.defaults.color = "#5b7590";

<?php if (count($porFecha) > 0) { ?>
new Chart(document.getElementById("graficoIngresos"), {
    type: "line",
    data: {
        labels: <?php echo json_encode(array_keys($porFecha)); ?>,
        datasets: [{
            label: "Ingresos en Bs.",
            data: <?php echo json_encode(array_values($porFecha)); ?>,
            borderColor: "#29a8e0",
            backgroundColor: "rgba(99,212,242,0.25)",
            pointBackgroundColor: "#0e2a4d",
            borderWidth: 3,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(c){ return "Bs. " + c.parsed.y.toFixed(2); }
                }
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { callback: function(v){ return "Bs. " + v; } } }
        }
    }
});
<?php } ?>

<?php if (count($topNombres) > 0) { ?>
new Chart(document.getElementById("graficoProductos"), {
    type: "bar",
    data: {
        labels: <?php echo json_encode($topNombres); ?>,
        datasets: [{
            data: <?php echo json_encode($topCantidades); ?>,
            backgroundColor: ["#0e2a4d", "#29a8e0", "#7be0c4"],
            borderRadius: 8
        }]
    },
    options: {
        indexAxis: "y",
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(c){ return c.parsed.x + " unidades"; }
                }
            }
        },
        scales: {
            x: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});
<?php } ?>

</script>

</body>
</html>