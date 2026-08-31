<?php

// ==========================================================
// REPORTE DE INGRESOS - EDSON
// Archivo: ingre-total.php
// Compatible con PHP 5.4+
// ==========================================================

// ==========================================================
// CONFIGURACIÓN
// ==========================================================

$archivo = __DIR__ . DIRECTORY_SEPARATOR . "ingresos.json";

// Nombre del archivo actual
$paginaActual = basename(__FILE__);

// ==========================================================
// CARGAR INGRESOS
// ==========================================================

$ingresos = array();

if (file_exists($archivo)) {

    $contenido = file_get_contents($archivo);

    if ($contenido !== false && trim($contenido) !== "") {

        $datos = json_decode($contenido, true);

        if (is_array($datos)) {
            $ingresos = $datos;
        }
    }
}

// ==========================================================
// FUNCIÓN PARA GUARDAR JSON
// ==========================================================

function guardarIngresos($archivo, $ingresos)
{
    $json = json_encode(
        $ingresos,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    file_put_contents($archivo, $json);
}

// ==========================================================
// FUNCIÓN PARA REDIRECCIONAR
// ==========================================================

function volverPagina($paginaActual)
{
    header("Location: " . $paginaActual);
    exit;
}

// ==========================================================
// PROCESAR FORMULARIOS
// ==========================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ======================================================
    // GUARDAR NUEVO INGRESO
    // ======================================================

    if (isset($_POST["guardar"])) {

        $fecha = isset($_POST["fecha"])
            ? trim($_POST["fecha"])
            : "";

        $descripcion = isset($_POST["descripcion"])
            ? trim($_POST["descripcion"])
            : "";

        $monto = isset($_POST["monto"])
            ? floatval($_POST["monto"])
            : 0;

        if (
            $fecha != "" &&
            $descripcion != "" &&
            $monto > 0
        ) {

            // Buscar el ID más alto
            $mayorId = 0;

            foreach ($ingresos as $ingreso) {

                if (isset($ingreso["id"])) {

                    $id = intval($ingreso["id"]);

                    if ($id > $mayorId) {
                        $mayorId = $id;
                    }
                }
            }

            $nuevoId = $mayorId + 1;

            // Crear ingreso
            $nuevoIngreso = array(
                "id" => $nuevoId,
                "fecha" => $fecha,
                "descripcion" => $descripcion,
                "monto" => $monto
            );

            $ingresos[] = $nuevoIngreso;

            guardarIngresos($archivo, $ingresos);

            volverPagina($paginaActual);
        }
    }

    // ======================================================
    // EDITAR INGRESO
    // ======================================================

    if (isset($_POST["editar"])) {

        $idEditar = isset($_POST["id"])
            ? intval($_POST["id"])
            : 0;

        $fecha = isset($_POST["fecha"])
            ? trim($_POST["fecha"])
            : "";

        $descripcion = isset($_POST["descripcion"])
            ? trim($_POST["descripcion"])
            : "";

        $monto = isset($_POST["monto"])
            ? floatval($_POST["monto"])
            : 0;

        if (
            $idEditar > 0 &&
            $fecha != "" &&
            $descripcion != "" &&
            $monto > 0
        ) {

            foreach ($ingresos as $indice => $ingreso) {

                if (
                    isset($ingreso["id"]) &&
                    intval($ingreso["id"]) == $idEditar
                ) {

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

    // ======================================================
    // ELIMINAR INGRESO
    // ======================================================

    if (isset($_POST["eliminar"])) {

        $idEliminar = isset($_POST["id"])
            ? intval($_POST["id"])
            : 0;

        $nuevosIngresos = array();

        foreach ($ingresos as $ingreso) {

            if (
                !isset($ingreso["id"]) ||
                intval($ingreso["id"]) != $idEliminar
            ) {

                $nuevosIngresos[] = $ingreso;
            }
        }

        $ingresos = $nuevosIngresos;

        guardarIngresos($archivo, $ingresos);

        volverPagina($paginaActual);
    }
}

// ==========================================================
// FILTROS
// ==========================================================

$tipo = isset($_GET["tipo"])
    ? $_GET["tipo"]
    : "todos";

$fechaSeleccionada = isset($_GET["fecha"])
    ? $_GET["fecha"]
    : date("Y-m-d");

$busqueda = isset($_GET["buscar"])
    ? trim($_GET["buscar"])
    : "";

$resultados = $ingresos;

// ==========================================================
// FILTRO POR DÍA
// ==========================================================

if ($tipo == "dia") {

    $resultados = array_filter(
        $resultados,
        function ($ingreso) use ($fechaSeleccionada) {

            if (!isset($ingreso["fecha"])) {
                return false;
            }

            return $ingreso["fecha"] == $fechaSeleccionada;
        }
    );
}

// ==========================================================
// FILTRO POR SEMANA
// ==========================================================

if ($tipo == "semana") {

    try {

        $fecha = new DateTime($fechaSeleccionada);

        // 1 = lunes
        // 7 = domingo
        $diaSemana = intval($fecha->format("N"));

        $inicioSemana = clone $fecha;

        $inicioSemana->modify(
            "-" . ($diaSemana - 1) . " days"
        );

        $finSemana = clone $inicioSemana;

        $finSemana->modify("+6 days");

        $inicioTexto = $inicioSemana->format("Y-m-d");
        $finTexto = $finSemana->format("Y-m-d");

        $resultados = array_filter(
            $resultados,
            function ($ingreso) use (
                $inicioTexto,
                $finTexto
            ) {

                if (!isset($ingreso["fecha"])) {
                    return false;
                }

                return
                    $ingreso["fecha"] >= $inicioTexto &&
                    $ingreso["fecha"] <= $finTexto;
            }
        );

    } catch (Exception $e) {

        $resultados = array();
    }
}

// ==========================================================
// FILTRO POR MES
// ==========================================================

if ($tipo == "mes") {

    try {

        $fecha = new DateTime($fechaSeleccionada);

        $mes = $fecha->format("m");
        $año = $fecha->format("Y");

        $resultados = array_filter(
            $resultados,
            function ($ingreso) use ($mes, $año) {

                if (!isset($ingreso["fecha"])) {
                    return false;
                }

                try {

                    $fechaIngreso =
                        new DateTime($ingreso["fecha"]);

                    return
                        $fechaIngreso->format("m") == $mes &&
                        $fechaIngreso->format("Y") == $año;

                } catch (Exception $e) {

                    return false;
                }
            }
        );

    } catch (Exception $e) {

        $resultados = array();
    }
}

// ==========================================================
// FILTRO POR AÑO
// ==========================================================

if ($tipo == "año") {

    try {

        $fecha = new DateTime($fechaSeleccionada);

        $año = $fecha->format("Y");

        $resultados = array_filter(
            $resultados,
            function ($ingreso) use ($año) {

                if (!isset($ingreso["fecha"])) {
                    return false;
                }

                try {

                    $fechaIngreso =
                        new DateTime($ingreso["fecha"]);

                    return
                        $fechaIngreso->format("Y") == $año;

                } catch (Exception $e) {

                    return false;
                }
            }
        );

    } catch (Exception $e) {

        $resultados = array();
    }
}

// ==========================================================
// FILTRO DE BÚSQUEDA
// ==========================================================

if ($busqueda != "") {

    $resultados = array_filter(
        $resultados,
        function ($ingreso) use ($busqueda) {

            if (!isset($ingreso["descripcion"])) {
                return false;
            }

            return
                stripos(
                    $ingreso["descripcion"],
                    $busqueda
                ) !== false;
        }
    );
}

// ==========================================================
// REINDEXAR RESULTADOS
// ==========================================================

$resultados = array_values($resultados);

// ==========================================================
// ORDENAR DEL MÁS RECIENTE AL MÁS ANTIGUO
// ==========================================================

usort(
    $resultados,
    function ($a, $b) {

        $fechaA = isset($a["fecha"])
            ? $a["fecha"]
            : "";

        $fechaB = isset($b["fecha"])
            ? $b["fecha"]
            : "";

        if ($fechaA == $fechaB) {

            $idA = isset($a["id"])
                ? intval($a["id"])
                : 0;

            $idB = isset($b["id"])
                ? intval($b["id"])
                : 0;

            if ($idA == $idB) {
                return 0;
            }

            return ($idA < $idB) ? 1 : -1;
        }

        return ($fechaA < $fechaB) ? 1 : -1;
    }
);

// ==========================================================
// CALCULAR TOTAL
// ==========================================================

$total = 0;

foreach ($resultados as $ingreso) {

    if (isset($ingreso["monto"])) {

        $total += floatval($ingreso["monto"]);
    }
}

// ==========================================================
// DATOS PARA MOSTRAR EL TÍTULO DEL FILTRO
// ==========================================================

$textoFiltro = "Todos los ingresos";

if ($tipo == "dia") {
    $textoFiltro = "Ingresos del día";
}

if ($tipo == "semana") {
    $textoFiltro = "Ingresos de la semana";
}

if ($tipo == "mes") {
    $textoFiltro = "Ingresos del mes";
}

if ($tipo == "año") {
    $textoFiltro = "Ingresos del año";
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reporte de Ingresos</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #eef2f7;
            color: #1e293b;
        }

        .contenedor {
            width: 95%;
            max-width: 1150px;
            margin: 25px auto;
        }

        /* ================================
           CABECERA
        ================================= */

        .titulo {
            background: linear-gradient(
                135deg,
                #1d4ed8,
                #2563eb
            );

            color: white;
            padding: 30px 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.12);
        }

        .titulo h1 {
            margin: 0;
            font-size: 30px;
        }

        .titulo p {
            margin: 8px 0 0;
            font-size: 18px;
            opacity: 0.9;
        }

        /* ================================
           TARJETAS
        ================================= */

        .formulario,
        .filtros,
        .tabla-contenedor {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
            margin-bottom: 20px;
        }

        .formulario h2 {
            margin-top: 0;
        }

        /* ================================
           CAMPOS
        ================================= */

        .campos {
            display: grid;
            grid-template-columns:
                1fr 2fr 1fr auto;

            gap: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            background: white;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow:
                0 0 0 2px rgba(37,99,235,0.12);
        }

        /* ================================
           BOTONES
        ================================= */

        button {
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-guardar {
            background: #16a34a;
            color: white;
        }

        .btn-guardar:hover {
            background: #15803d;
        }

        .btn-editar {
            background: #2563eb;
            color: white;
            padding: 8px 12px;
        }

        .btn-editar:hover {
            background: #1d4ed8;
        }

        .btn-eliminar {
            background: #dc2626;
            color: white;
            padding: 8px 12px;
        }

        .btn-eliminar:hover {
            background: #b91c1c;
        }

        /* ================================
           FILTROS
        ================================= */

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filtros a {
            text-decoration: none;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .dia {
            background: #2563eb;
        }

        .semana {
            background: #7c3aed;
        }

        .mes {
            background: #ea580c;
        }

        .año {
            background: #0891b2;
        }

        .todos {
            background: #475569;
        }

        .filtros a:hover {
            opacity: 0.85;
        }

        /* ================================
           BUSCADOR
        ================================= */

        .buscador {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
        }

        /* ================================
           TOTAL
        ================================= */

        .total {
            background: linear-gradient(
                135deg,
                #dcfce7,
                #bbf7d0
            );

            border: 2px solid #16a34a;
            padding: 25px;
            border-radius: 14px;
            text-align: center;
            margin-bottom: 20px;
        }

        .total h2 {
            margin: 0;
            color: #166534;
            font-size: 27px;
        }

        .subtitulo-total {
            margin-top: 8px;
            color: #15803d;
            font-size: 14px;
        }

        /* ================================
           TABLA
        ================================= */

        .tabla-contenedor {
            overflow-x: auto;
        }

        .tabla-titulo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .tabla-titulo h2 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1e293b;
            color: white;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        tr:hover {
            background: #f8fafc;
        }

        .monto {
            font-weight: bold;
            color: #15803d;
        }

        .acciones {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        /* ================================
           SIN DATOS
        ================================= */

        .sin-datos {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
        }

        .sin-datos strong {
            display: block;
            font-size: 18px;
            margin-bottom: 8px;
            color: #475569;
        }

        /* ================================
           MODAL EDITAR
        ================================= */

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(15,23,42,0.65);
            padding: 20px;
        }

        .modal-contenido {
            background: white;
            max-width: 500px;
            margin: 70px auto;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }

        .modal-contenido h2 {
            margin-top: 0;
        }

        .campo-modal {
            margin-bottom: 15px;
        }

        .campo-modal label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .botones-modal {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-cancelar {
            background: #64748b;
            color: white;
        }

        /* ================================
           RESPONSIVE
        ================================= */

        @media (max-width: 800px) {

            .campos {
                grid-template-columns: 1fr;
            }

            .filtros {
                flex-direction: column;
            }

            .filtros a {
                width: 100%;
            }

            .buscador {
                grid-template-columns: 1fr;
            }

            .tabla-titulo {
                flex-direction: column;
                align-items: flex-start;
            }

            .acciones {
                flex-direction: column;
            }

            .acciones button {
                width: 100%;
            }

            th,
            td {
                white-space: nowrap;
            }

            .titulo h1 {
                font-size: 24px;
            }

            .total h2 {
                font-size: 22px;
            }
        }

    </style>

</head>

<body>

<div class="contenedor">

    <!-- ==================================================
         TÍTULO
    =================================================== -->

    <div class="titulo">

        <h1>REPORTE DE INGRESOS</h1>

        <p>EDSON</p>

    </div>


    <!-- ==================================================
         REGISTRAR INGRESO
    =================================================== -->

    <div class="formulario">

        <h2>➕ Registrar nuevo ingreso</h2>

        <form method="POST">

            <div class="campos">

                <input
                    type="date"
                    name="fecha"
                    value="<?php echo date("Y-m-d"); ?>"
                    required
                >

                <input
                    type="text"
                    name="descripcion"
                    placeholder="Descripción del ingreso"
                    maxlength="150"
                    required
                >

                <input
                    type="number"
                    name="monto"
                    placeholder="Monto en Bs."
                    step="0.01"
                    min="0.01"
                    required
                >

                <button
                    type="submit"
                    name="guardar"
                    class="btn-guardar">

                    GUARDAR

                </button>

            </div>

        </form>

    </div>


    <!-- ==================================================
         FILTROS
    =================================================== -->

    <div class="filtros">

        <a
            class="todos"
            href="<?php echo $paginaActual; ?>">

            TODOS

        </a>

        <a
            class="dia"
            href="<?php echo $paginaActual; ?>?tipo=dia&amp;fecha=<?php echo urlencode($fechaSeleccionada); ?>">

            📅 POR DÍA

        </a>

        <a
            class="semana"
            href="<?php echo $paginaActual; ?>?tipo=semana&amp;fecha=<?php echo urlencode($fechaSeleccionada); ?>">

            📆 POR SEMANA

        </a>

        <a
            class="mes"
            href="<?php echo $paginaActual; ?>?tipo=mes&amp;fecha=<?php echo urlencode($fechaSeleccionada); ?>">

            🗓️ POR MES

        </a>

        <a
            class="año"
            href="<?php echo $paginaActual; ?>?tipo=año&amp;fecha=<?php echo urlencode($fechaSeleccionada); ?>">

            📊 POR AÑO

        </a>

    </div>


    <!-- ==================================================
         SELECCIONAR FECHA
    =================================================== -->

    <div class="formulario">

        <form method="GET">

            <label>

                <strong>Seleccionar fecha para el reporte:</strong>

            </label>

            <br><br>

            <input
                type="date"
                name="fecha"
                value="<?php echo htmlspecialchars($fechaSeleccionada); ?>"
                required
            >

            <input
                type="hidden"
                name="tipo"
                value="<?php echo htmlspecialchars($tipo); ?>"
            >

            <button
                type="submit"
                class="btn-guardar">

                🔎 CONSULTAR

            </button>

        </form>

    </div>


    <!-- ==================================================
         BUSCAR
    =================================================== -->

    <div class="formulario">

        <h2>🔍 Buscar ingreso</h2>

        <form method="GET">

            <input
                type="hidden"
                name="tipo"
                value="<?php echo htmlspecialchars($tipo); ?>"
            >

            <input
                type="hidden"
                name="fecha"
                value="<?php echo htmlspecialchars($fechaSeleccionada); ?>"
            >

            <div class="buscador">

                <input
                    type="text"
                    name="buscar"
                    placeholder="Buscar por descripción..."
                    value="<?php echo htmlspecialchars($busqueda); ?>"
                >

                <button
                    type="submit"
                    class="btn-guardar">

                    BUSCAR

                </button>

            </div>

        </form>

    </div>


    <!-- ==================================================
         TOTAL
    =================================================== -->

    <div class="total">

        <h2>

            TOTAL:

            Bs.
            <?php echo number_format($total, 2); ?>

        </h2>

        <div class="subtitulo-total">

            <?php echo htmlspecialchars($textoFiltro); ?>

            <?php if ($busqueda != ""): ?>

                — búsqueda:
                "<?php echo htmlspecialchars($busqueda); ?>"

            <?php endif; ?>

        </div>

    </div>


    <!-- ==================================================
         TABLA
    =================================================== -->

    <div class="tabla-contenedor">

        <div class="tabla-titulo">

            <h2>Detalle de ingresos</h2>

            <strong>

                Registros:
                <?php echo count($resultados); ?>

            </strong>

        </div>


        <?php if (count($resultados) > 0): ?>

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Fecha</th>

                        <th>Descripción</th>

                        <th>Monto</th>

                        <th>Acción</th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach ($resultados as $ingreso): ?>

                    <?php

                    $idIngreso = isset($ingreso["id"])
                        ? intval($ingreso["id"])
                        : 0;

                    $fechaIngreso = isset($ingreso["fecha"])
                        ? $ingreso["fecha"]
                        : "";

                    $descripcionIngreso =
                        isset($ingreso["descripcion"])
                        ? $ingreso["descripcion"]
                        : "";

                    $montoIngreso =
                        isset($ingreso["monto"])
                        ? floatval($ingreso["monto"])
                        : 0;

                    ?>

                    <tr>

                        <!-- ID -->

                        <td>

                            <?php echo $idIngreso; ?>

                        </td>


                        <!-- FECHA -->

                        <td>

                            <?php

                            if ($fechaIngreso != "") {

                                echo date(
                                    "d/m/Y",
                                    strtotime($fechaIngreso)
                                );

                            }

                            ?>

                        </td>


                        <!-- DESCRIPCIÓN -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $descripcionIngreso
                            );

                            ?>

                        </td>


                        <!-- MONTO -->

                        <td class="monto">

                            Bs.
                            <?php

                            echo number_format(
                                $montoIngreso,
                                2
                            );

                            ?>

                        </td>


                        <!-- ACCIONES -->

                        <td>

                            <div class="acciones">

                                <!-- EDITAR -->

                                <button
                                    type="button"
                                    class="btn-editar"
                                    onclick="abrirEditar(
                                        <?php echo $idIngreso; ?>,
                                        '<?php echo htmlspecialchars($fechaIngreso, ENT_QUOTES); ?>',
                                        '<?php echo htmlspecialchars($descripcionIngreso, ENT_QUOTES); ?>',
                                        '<?php echo $montoIngreso; ?>'
                                    );">

                                    ✏️ EDITAR

                                </button>


                                <!-- ELIMINAR -->

                                <form
                                    method="POST"
                                    style="display:inline;">

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $idIngreso; ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="eliminar"
                                        class="btn-eliminar"
                                        onclick="return confirm(
                                            '¿Está seguro de eliminar este ingreso?'
                                        );">

                                        🗑️ ELIMINAR

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        <?php else: ?>

            <div class="sin-datos">

                <strong>📭 No existen ingresos</strong>

                No hay ingresos registrados para este período o búsqueda.

            </div>

        <?php endif; ?>

    </div>

</div>


<!-- ======================================================
     MODAL PARA EDITAR
======================================================= -->

<div
    id="modalEditar"
    class="modal">

    <div class="modal-contenido">

        <h2>✏️ Editar ingreso</h2>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                id="editarId"
            >


            <div class="campo-modal">

                <label>Fecha</label>

                <input
                    type="date"
                    name="fecha"
                    id="editarFecha"
                    required
                >

            </div>


            <div class="campo-modal">

                <label>Descripción</label>

                <input
                    type="text"
                    name="descripcion"
                    id="editarDescripcion"
                    maxlength="150"
                    required
                >

            </div>


            <div class="campo-modal">

                <label>Monto en Bs.</label>

                <input
                    type="number"
                    name="monto"
                    id="editarMonto"
                    step="0.01"
                    min="0.01"
                    required
                >

            </div>


            <div class="botones-modal">

                <button
                    type="button"
                    class="btn-cancelar"
                    onclick="cerrarEditar();">

                    CANCELAR

                </button>

                <button
                    type="submit"
                    name="editar"
                    class="btn-guardar">

                    💾 GUARDAR CAMBIOS

                </button>

            </div>

        </form>

    </div>

</div>


<!-- ======================================================
     JAVASCRIPT
======================================================= -->

<script>

function abrirEditar(
    id,
    fecha,
    descripcion,
    monto
) {

    document.getElementById("editarId").value = id;

    document.getElementById("editarFecha").value = fecha;

    document.getElementById(
        "editarDescripcion"
    ).value = descripcion;

    document.getElementById(
        "editarMonto"
    ).value = monto;

    document.getElementById(
        "modalEditar"
    ).style.display = "block";
}


function cerrarEditar()
{
    document.getElementById(
        "modalEditar"
    ).style.display = "none";
}


window.onclick = function(event)
{
    var modal =
        document.getElementById("modalEditar");

    if (event.target == modal) {

        cerrarEditar();
    }
};

</script>

</body>

</html>
