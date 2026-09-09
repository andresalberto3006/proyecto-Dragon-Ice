<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: ../iniciosesion.php");
    exit();
}

$esAdmin = $_SESSION['rol'] === 'Administrador';

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "dragonice";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$sqlProductos = "
    SELECT productos.nombre, SUM(carrito.cantidad) AS cantidad
    FROM carrito
    INNER JOIN productos ON carrito.productos_id = productos.id
    INNER JOIN ventas ON carrito.pedidos_id = ventas.pedidos_id
    GROUP BY productos.id, productos.nombre
    ORDER BY cantidad DESC
    LIMIT 3
";
$resultadoProductos = $conn->query($sqlProductos);

$productosGrafico = [];
$cantidadesGrafico = [];

if ($resultadoProductos !== false) {
    while ($fila = $resultadoProductos->fetch_assoc()) {
        $productosGrafico[] = $fila["nombre"];
        $cantidadesGrafico[] = intval($fila["cantidad"]);
    }
}

$archivo = __DIR__ . DIRECTORY_SEPARATOR . "ingresos.json";
$paginaActual = basename(__FILE__);

$ingresos = [];

if (file_exists($archivo)) {
    $contenido = file_get_contents($archivo);
    if ($contenido !== false && trim($contenido) !== "") {
        $datos = json_decode($contenido, true);
        if (is_array($datos)) {
            $ingresos = $datos;
        }
    }
}

function guardarIngresos($archivo, $ingresos) {
    $json = json_encode($ingresos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($archivo, $json);
}

function volverPagina($paginaActual) {
    header("Location: " . $paginaActual);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $esAdmin) {

    if (isset($_POST["guardar"])) {

        $fecha = trim($_POST["fecha"] ?? "");
        $descripcion = trim($_POST["descripcion"] ?? "");
        $monto = floatval($_POST["monto"] ?? 0);

        if ($fecha !== "" && $descripcion !== "" && $monto > 0) {

            $mayorId = 0;
            foreach ($ingresos as $ingreso) {
                $id = intval($ingreso["id"] ?? 0);
                if ($id > $mayorId) $mayorId = $id;
            }

            $ingresos[] = [
                "id" => $mayorId + 1,
                "fecha" => $fecha,
                "descripcion" => $descripcion,
                "monto" => $monto
            ];

            guardarIngresos($archivo, $ingresos);
            volverPagina($paginaActual);
        }
    }

    if (isset($_POST["editar"])) {

        $idEditar = intval($_POST["id"] ?? 0);
        $fecha = trim($_POST["fecha"] ?? "");
        $descripcion = trim($_POST["descripcion"] ?? "");
        $monto = floatval($_POST["monto"] ?? 0);

        if ($idEditar > 0 && $fecha !== "" && $descripcion !== "" && $monto > 0) {

            foreach ($ingresos as $indice => $ingreso) {
                if (intval($ingreso["id"] ?? 0) === $idEditar) {
                    $ingresos[$indice]["fecha"] = $fecha;
                    $ingresos[$indice]["descripcion"] = $descripcion;
                    $ingresos[$indice]["monto"] = $monto;
                    break;
                }
            }

            guardarIngresos($archivo, $ingresos);
            volverPagina($paginaActual);
        }
    }

    if (isset($_POST["eliminar"])) {

        $idEliminar = intval($_POST["id"] ?? 0);

        $ingresos = array_values(array_filter($ingresos, function ($ingreso) use ($idEliminar) {
            return intval($ingreso["id"] ?? 0) !== $idEliminar;
        }));

        guardarIngresos($archivo, $ingresos);
        volverPagina($paginaActual);
    }
}
$tipo = $_GET["tipo"] ?? "todos";
$fechaSeleccionada = $_GET["fecha"] ?? date("Y-m-d");
$busqueda = trim($_GET["buscar"] ?? "");

$resultados = $ingresos;

if ($tipo === "dia") {
    $resultados = array_filter($resultados, function ($i) use ($fechaSeleccionada) {
        return ($i["fecha"] ?? "") === $fechaSeleccionada;
    });
}

if ($tipo === "semana") {
    try {
        $fecha = new DateTime($fechaSeleccionada);
        $diaSemana = intval($fecha->format("N"));
        $inicioSemana = (clone $fecha)->modify("-" . ($diaSemana - 1) . " days");
        $finSemana = (clone $inicioSemana)->modify("+6 days");
        $inicioTexto = $inicioSemana->format("Y-m-d");
        $finTexto = $finSemana->format("Y-m-d");

        $resultados = array_filter($resultados, function ($i) use ($inicioTexto, $finTexto) {
            $f = $i["fecha"] ?? "";
            return $f !== "" && $f >= $inicioTexto && $f <= $finTexto;
        });
    } catch (Exception $e) {
        $resultados = [];
    }
}

if ($tipo === "mes") {
    try {
        $fecha = new DateTime($fechaSeleccionada);
        $mes = $fecha->format("m");
        $anio = $fecha->format("Y");

        $resultados = array_filter($resultados, function ($i) use ($mes, $anio) {
            if (empty($i["fecha"])) return false;
            try {
                $f = new DateTime($i["fecha"]);
                return $f->format("m") === $mes && $f->format("Y") === $anio;
            } catch (Exception $e) {
                return false;
            }
        });
    } catch (Exception $e) {
        $resultados = [];
    }
}

if ($tipo === "año") {
    try {
        $fecha = new DateTime($fechaSeleccionada);
        $anio = $fecha->format("Y");

        $resultados = array_filter($resultados, function ($i) use ($anio) {
            if (empty($i["fecha"])) return false;
            try {
                $f = new DateTime($i["fecha"]);
                return $f->format("Y") === $anio;
            } catch (Exception $e) {
                return false;
            }
        });
    } catch (Exception $e) {
        $resultados = [];
    }
}

if ($busqueda !== "") {
    $resultados = array_filter($resultados, function ($i) use ($busqueda) {
        return isset($i["descripcion"]) && stripos($i["descripcion"], $busqueda) !== false;
    });
}

$resultados = array_values($resultados);

usort($resultados, function ($a, $b) {
    return strcmp($b["fecha"] ?? "", $a["fecha"] ?? "");
});

$total = 0;
foreach ($resultados as $ingreso) {
    $total += floatval($ingreso["monto"] ?? 0);
}

// Datos para el gráfico de ingresos
$ingresosPorFecha = [];
foreach ($resultados as $ingreso) {
    if (isset($ingreso["fecha"], $ingreso["monto"])) {
        $fecha = $ingreso["fecha"];
        $ingresosPorFecha[$fecha] = ($ingresosPorFecha[$fecha] ?? 0) + floatval($ingreso["monto"]);
    }
}
ksort($ingresosPorFecha);

$fechasGrafico = array_keys($ingresosPorFecha);
$montosGrafico = array_values($ingresosPorFecha);

$textoFiltro = match ($tipo) {
    "dia" => "Ingresos del día",
    "semana" => "Ingresos de la semana",
    "mes" => "Ingresos del mes",
    "año" => "Ingresos del año",
    default => "Todos los ingresos",
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reporte de Ingresos</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

:root{
    --azul-oscuro:#0e2a4d;
    --azul-medio:#173a8a;
    --celeste:#29a8e0;
    --celeste-claro:#63d4f2;
    --menta:#7be0c4;
    --gris-texto:#5b7590;
    --gris-borde:#dcecf3;
    --rojo:#dc3545;
}

* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: 'Inter', Arial, Helvetica, sans-serif;
    background: linear-gradient(180deg,#e8f2fb,#f5f9fd 40%);
    color: var(--azul-oscuro);
}

.contenedor { width: 95%; max-width: 1150px; margin: 25px auto; }

.titulo{
    background:linear-gradient(135deg,var(--azul-oscuro),var(--celeste));
    color:white;
    padding:30px 20px;
    border-radius:15px;
    text-align:center;
    margin-bottom:20px;
    box-shadow:0 8px 20px rgba(14,42,77,0.25);
}
.titulo h1 { margin: 0; font-size: 30px; letter-spacing:1px; }
.titulo p { margin: 8px 0 0; font-size: 16px; color:var(--celeste-claro); }

.formulario, .filtros, .tabla-contenedor, .grafico-contenedor{
    background:white;
    padding:20px;
    border-radius:14px;
    box-shadow:0 4px 14px rgba(14,42,77,0.08);
    margin-bottom:20px;
    border:1px solid var(--gris-borde);
}

.formulario h2,
.grafico-contenedor h2,
.tabla-titulo h2{
    color:var(--azul-medio);
}

.campos { display: grid; grid-template-columns: 1fr 2fr 1fr auto; gap: 10px; }

input{
    width:100%;
    padding:12px;
    border:1px solid var(--gris-borde);
    border-radius:8px;
    font-size:15px;
    color:var(--azul-oscuro);
}

input:focus{
    outline:none;
    border-color:var(--celeste);
    box-shadow:0 0 0 2px rgba(41,168,224,0.25);
}

button { border: none; padding: 12px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; transition:.25s; }

.btn-guardar{ background:var(--celeste); color:white; }
.btn-guardar:hover{ background:var(--azul-oscuro); }

.btn-editar{ background:var(--menta); color:var(--azul-oscuro); padding:8px 12px; }
.btn-editar:hover{ background:#5fcfab; }

.btn-eliminar{ background:var(--rojo); color:white; padding:8px 12px; }
.btn-eliminar:hover{ background:#b52a37; }

.btn-cancelar{ background:var(--gris-texto); color:white; }
.btn-cancelar:hover{ background:var(--azul-oscuro); }

.filtros { display: flex; flex-wrap: wrap; gap: 10px; }
.filtros a{
    text-decoration:none;
    color:white;
    padding:12px 18px;
    border-radius:8px;
    font-weight:bold;
    transition:.2s;
}
.filtros a:hover{ transform:translateY(-2px); opacity:.92; }

.todos{ background:var(--azul-oscuro); }
.dia{ background:var(--celeste); }
.semana{ background:var(--azul-medio); }
.mes{ background:#1c8fc4; }
.año{ background:#0c5f89; }

.buscador { display: grid; grid-template-columns: 1fr auto; gap: 10px; }

.total{
    background:linear-gradient(135deg,#e3faf1,#c8f4e3);
    border:2px solid var(--menta);
    padding:25px;
    border-radius:14px;
    text-align:center;
    margin-bottom:20px;
}
.total h2{ margin:0; color:var(--azul-oscuro); font-size:27px; }
.subtitulo-total{ margin-top:8px; color:#1c8fc4; font-weight:600; }

.grafico-contenedor h2 { margin-top: 0; }
.grafico-contenedor canvas { width: 100% !important; max-height: 400px; }

.tabla-contenedor { overflow-x: auto; }
.tabla-titulo { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }

table { width: 100%; border-collapse: collapse; }
th{ background:var(--azul-oscuro); color:white; padding:14px; text-align:left; }
td{ padding:12px; border-bottom:1px solid var(--gris-borde); }
tr:hover{ background:#f4f8ff; }

.monto{ font-weight:bold; color:#1c8fc4; }
.acciones { display: flex; gap: 6px; }

.sin-datos { text-align: center; padding: 40px; color: var(--gris-texto); }

.modal{
    display:none;
    position:fixed;
    z-index:1000;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(14,42,77,0.65);
    padding:20px;
}
.modal-contenido{
    background:white;
    max-width:500px;
    margin:70px auto;
    padding:25px;
    border-radius:15px;
    border:1px solid var(--gris-borde);
}
.campo-modal { margin-bottom: 15px; }
.campo-modal label{ display:block; font-weight:bold; margin-bottom:6px; color:var(--azul-medio); }
.botones-modal { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }

@media (max-width: 800px) {
    .campos { grid-template-columns: 1fr; }
    .filtros { flex-direction: column; }
    .filtros a { width: 100%; text-align: center; }
    .buscador { grid-template-columns: 1fr; }
    .tabla-titulo { flex-direction: column; align-items: flex-start; }
    .acciones { flex-direction: column; }
}
</style>
</head>
<body>

<header class="menu-principal">
<?php $rutaMenu = "../"; include("../menu.php"); ?>
</header>

<div class="contenedor">

<div class="titulo">
    <h1>REPORTE DE INGRESOS</h1>
    <p>DRAGON ICE</p>
</div>

<?php if ($esAdmin): ?>
<div class="formulario">
    <h2>Registrar nuevo ingreso</h2>
    <form method="POST">
        <div class="campos">
            <input type="date" name="fecha" value="<?php echo date("Y-m-d"); ?>" required>
            <input type="text" name="descripcion" placeholder="Descripción del ingreso" maxlength="150" required>
            <input type="number" name="monto" placeholder="Monto en Bs." step="0.01" min="0.01" required>
            <button type="submit" name="guardar" class="btn-guardar">GUARDAR</button>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="filtros">
    <a class="todos" href="<?php echo $paginaActual; ?>">TODOS</a>
    <a class="dia" href="<?php echo $paginaActual; ?>?tipo=dia&fecha=<?php echo urlencode($fechaSeleccionada); ?>">POR DÍA</a>
    <a class="semana" href="<?php echo $paginaActual; ?>?tipo=semana&fecha=<?php echo urlencode($fechaSeleccionada); ?>">POR SEMANA</a>
    <a class="mes" href="<?php echo $paginaActual; ?>?tipo=mes&fecha=<?php echo urlencode($fechaSeleccionada); ?>">POR MES</a>
    <a class="año" href="<?php echo $paginaActual; ?>?tipo=año&fecha=<?php echo urlencode($fechaSeleccionada); ?>">POR AÑO</a>
</div>

<div class="formulario">
    <form method="GET">
        <strong>Seleccionar fecha:</strong><br><br>
        <input type="date" name="fecha" value="<?php echo htmlspecialchars($fechaSeleccionada); ?>" required>
        <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
        <br><br>
        <button type="submit" class="btn-guardar">CONSULTAR</button>
    </form>
</div>

<div class="formulario">
    <h2>Buscar ingreso</h2>
    <form method="GET">
        <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
        <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fechaSeleccionada); ?>">
        <div class="buscador">
            <input type="text" name="buscar" placeholder="Buscar por descripción..." value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit" class="btn-guardar">BUSCAR</button>
        </div>
    </form>
</div>

<div class="total">
    <h2>TOTAL: Bs. <?php echo number_format($total, 2); ?></h2>
    <div class="subtitulo-total">
        <?php echo htmlspecialchars($textoFiltro); ?>
        <?php if ($busqueda !== ""): ?>
            — búsqueda: "<?php echo htmlspecialchars($busqueda); ?>"
        <?php endif; ?>
    </div>
</div>

<div class="grafico-contenedor">
    <h2>Evolución de ingresos</h2>
    <canvas id="graficoIngresos"></canvas>
</div>

<div class="grafico-contenedor">
    <h2>Top 3 productos más vendidos</h2>
    <canvas id="graficoProductos"></canvas>
</div>

<div class="tabla-contenedor">
    <div class="tabla-titulo">
        <h2>Detalle de ingresos</h2>
        <strong>Registros: <?php echo count($resultados); ?></strong>
    </div>

    <?php if (count($resultados) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Monto</th>
            <?php if ($esAdmin): ?><th>Acción</th><?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resultados as $ingreso): ?>
            <?php
                $idIngreso = intval($ingreso["id"] ?? 0);
                $fechaIngreso = $ingreso["fecha"] ?? "";
                $descripcionIngreso = $ingreso["descripcion"] ?? "";
                $montoIngreso = floatval($ingreso["monto"] ?? 0);
            ?>
            <tr>
                <td><?php echo $idIngreso; ?></td>
                <td><?php echo $fechaIngreso !== "" ? date("d/m/Y", strtotime($fechaIngreso)) : ""; ?></td>
                <td><?php echo htmlspecialchars($descripcionIngreso); ?></td>
                <td class="monto">Bs. <?php echo number_format($montoIngreso, 2); ?></td>

                <?php if ($esAdmin): ?>
                <td>
                    <div class="acciones">
                        <button type="button" class="btn-editar" onclick='abrirEditar(<?php echo json_encode($idIngreso); ?>, <?php echo json_encode($fechaIngreso); ?>, <?php echo json_encode($descripcionIngreso); ?>, <?php echo json_encode($montoIngreso); ?>);'>
                            EDITAR
                        </button>

                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $idIngreso; ?>">
                            <button type="submit" name="eliminar" class="btn-eliminar" onclick="return confirm('¿Está seguro de eliminar este ingreso?');">
                                ELIMINAR
                            </button>
                        </form>
                    </div>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="sin-datos">
        <strong>No existen ingresos</strong><br>
        No hay ingresos registrados para este período.
    </div>
    <?php endif; ?>
</div>

</div>

<?php if ($esAdmin): ?>
<div id="modalEditar" class="modal">
    <div class="modal-contenido">
        <h2>Editar ingreso</h2>
        <form method="POST">
            <input type="hidden" name="id" id="editarId">

            <div class="campo-modal">
                <label>Fecha</label>
                <input type="date" name="fecha" id="editarFecha" required>
            </div>

            <div class="campo-modal">
                <label>Descripción</label>
                <input type="text" name="descripcion" id="editarDescripcion" maxlength="150" required>
            </div>

            <div class="campo-modal">
                <label>Monto en Bs.</label>
                <input type="number" name="monto" id="editarMonto" step="0.01" min="0.01" required>
            </div>

            <div class="botones-modal">
                <button type="button" class="btn-cancelar" onclick="cerrarEditar();">CANCELAR</button>
                <button type="submit" name="editar" class="btn-guardar">GUARDAR CAMBIOS</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirEditar(id, fecha, descripcion, monto) {
    document.getElementById("editarId").value = id;
    document.getElementById("editarFecha").value = fecha;
    document.getElementById("editarDescripcion").value = descripcion;
    document.getElementById("editarMonto").value = monto;
    document.getElementById("modalEditar").style.display = "block";
}

function cerrarEditar() {
    document.getElementById("modalEditar").style.display = "none";
}

window.onclick = function (event) {
    const modal = document.getElementById("modalEditar");
    if (event.target === modal) cerrarEditar();
};
</script>
<?php endif; ?>

<script>
const fechasGrafico = <?php echo json_encode($fechasGrafico); ?>;
const montosGrafico = <?php echo json_encode($montosGrafico); ?>;

new Chart(document.getElementById("graficoIngresos"), {
    type: "line",
    data: {
        labels: fechasGrafico,
        datasets: [{
            label: "Ingresos en Bs.",
            data: montosGrafico,
            borderColor: "#157baa",
            backgroundColor: "rgba(41,168,224,0.15)",
            borderWidth: 3,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true, position: "top" },
            title: { display: true, text: "Evolución de ingresos" }
        },
        scales: {
            y: { beginAtZero: true, title: { display: true, text: "Monto en Bs." } },
            x: { title: { display: true, text: "Fecha" } }
        }
    }
});

const productosGrafico = <?php echo json_encode($productosGrafico); ?>;
const cantidadesGrafico = <?php echo json_encode($cantidadesGrafico); ?>;

new Chart(document.getElementById("graficoProductos"), {
    type: "bar",
    data: {
        labels: productosGrafico,
        datasets: [{
            label: "Cantidad vendida",
            data: cantidadesGrafico,
            backgroundColor: "#2083bd",
            borderColor: "#0e2a4d",
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true, position: "top" },
            title: { display: true, text: "Top 3 productos más vendidos" }
        },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 }, title: { display: true, text: "Cantidad vendida" } }
        }
    }
});
</script>

</body>
</html>