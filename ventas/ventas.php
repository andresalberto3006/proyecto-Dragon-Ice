<?php

session_start();

/* =========================================================
   SEGURIDAD
========================================================= */

if (!isset($_SESSION['rol'])) {
    header("Location: ../iniciosesion.php");
    exit();
}

/* =========================================================
   CONEXIÓN A BASE DE DATOS
========================================================= */

include("../conexion.php");

/* =========================================================
   DATOS DE SESIÓN
========================================================= */

$rol = $_SESSION['rol'];

$ci = "";

if (isset($_SESSION['ci'])) {
    $ci = $_SESSION['ci'];
}

/* =========================================================
   FILTROS
========================================================= */

$tipo = "todos";

if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
}

$fecha = date("Y-m-d");

if (isset($_GET['fecha']) && $_GET['fecha'] != "") {
    $fecha = $_GET['fecha'];
}

$buscar = "";

if (isset($_GET['buscar'])) {
    $buscar = trim($_GET['buscar']);
}

/* =========================================================
   CONSTRUIR CONSULTA
========================================================= */

$where = array();
$parametros = array();
$tipos = "";

/* =========================================================
   PERMISOS POR ROL
========================================================= */

if ($rol != "Administrador") {

    $where[] = "v.vendedor_ci = ?";

    $parametros[] = $ci;
    $tipos .= "s";
}

/* =========================================================
   FILTRO POR DÍA
========================================================= */

if ($tipo == "dia") {

    $where[] = "DATE(v.fecha) = ?";

    $parametros[] = $fecha;
    $tipos .= "s";
}

/* =========================================================
   FILTRO POR SEMANA
========================================================= */

if ($tipo == "semana") {

    $where[] = "YEARWEEK(v.fecha, 1) = YEARWEEK(?, 1)";

    $parametros[] = $fecha;
    $tipos .= "s";
}

/* =========================================================
   FILTRO POR MES
========================================================= */

if ($tipo == "mes") {

    $where[] = "YEAR(v.fecha) = YEAR(?)";

    $parametros[] = $fecha;
    $tipos .= "s";

    $where[] = "MONTH(v.fecha) = MONTH(?)";

    $parametros[] = $fecha;
    $tipos .= "s";
}

/* =========================================================
   FILTRO POR AÑO
========================================================= */

if ($tipo == "año") {

    $where[] = "YEAR(v.fecha) = YEAR(?)";

    $parametros[] = $fecha;
    $tipos .= "s";
}

/* =========================================================
   BUSCADOR
========================================================= */

if ($buscar != "") {

    $where[] = "(
        v.cliente LIKE ?
        OR v.nombrevendedor LIKE ?
        OR v.metodo_pago LIKE ?
        OR CAST(v.pedidos_id AS CHAR) LIKE ?
    )";

    $busquedaSQL = "%" . $buscar . "%";

    $parametros[] = $busquedaSQL;
    $parametros[] = $busquedaSQL;
    $parametros[] = $busquedaSQL;
    $parametros[] = $busquedaSQL;

    $tipos .= "ssss";
}

/* =========================================================
   ARMAR WHERE
========================================================= */

$whereSQL = "";

if (count($where) > 0) {

    $whereSQL = " WHERE " . implode(" AND ", $where);
}

/* =========================================================
   CONSULTA PRINCIPAL
========================================================= */

$sql = "
    SELECT
        v.id,
        v.pedidos_id,
        v.cliente,
        v.vendedor_ci,
        v.nombrevendedor,
        v.fecha,
        v.total,
        v.metodo_pago
    FROM ventas v
    $whereSQL
    ORDER BY v.fecha DESC, v.id DESC
";

/* =========================================================
   PREPARAR CONSULTA
========================================================= */

$stmt = $conexion->prepare($sql);

if (!$stmt) {

    die(
        "Error en la consulta: " .
        $conexion->error
    );
}

/* =========================================================
   ENLAZAR PARÁMETROS
========================================================= */

if (count($parametros) > 0) {

    $referencias = array();

    $referencias[] = $tipos;

    foreach ($parametros as $key => $valor) {
        $referencias[] = &$parametros[$key];
    }

    call_user_func_array(
        array($stmt, "bind_param"),
        $referencias
    );
}

/* =========================================================
   EJECUTAR
========================================================= */

$stmt->execute();

/* =========================================================
   OBTENER RESULTADOS
========================================================= */

$resultado = $stmt->get_result();

/* =========================================================
   CALCULAR TOTAL
========================================================= */

$totalIngresos = 0;

$cantidadVentas = 0;

while ($filaTemporal = $resultado->fetch_assoc()) {

    $totalIngresos += floatval($filaTemporal['total']);

    $cantidadVentas++;
}

/* =========================================================
   VOLVER AL INICIO DEL RESULTADO
========================================================= */

/*
   Como mysqli_result no permite volver fácilmente al inicio
   en todas las configuraciones, ejecutamos nuevamente la
   consulta para mostrar la tabla.
*/

$stmt->execute();

$resultado = $stmt->get_result();

/* =========================================================
   TEXTO DEL FILTRO
========================================================= */

$textoFiltro = "Todas las ventas";

if ($tipo == "dia") {

    $textoFiltro =
        "Ventas del día " .
        date("d/m/Y", strtotime($fecha));
}

if ($tipo == "semana") {

    $textoFiltro =
        "Ventas de la semana";
}

if ($tipo == "mes") {

    $textoFiltro =
        "Ventas del mes " .
        date("m/Y", strtotime($fecha));
}

if ($tipo == "año") {

    $textoFiltro =
        "Ventas del año " .
        date("Y", strtotime($fecha));
}

/* =========================================================
   RUTA DEL MENÚ
========================================================= */

$rutaMenu = "../";

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Reporte de Ingresos</title>

<style>

/* =========================================================
   GENERAL
========================================================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

html,
body {
    min-height: 100%;
}

body {
    background: #eef2f7;
}

/* =========================================================
   FONDO
========================================================= */

.fondo-panel {

    min-height: calc(100vh - 70px);

    background:
        linear-gradient(
            135deg,
            #18335c,
            #2f5d9f,
            #7fc7ff
        );

    padding: 35px 20px;
}

/* =========================================================
   CONTENEDOR
========================================================= */

.contenedor {

    width: 100%;

    max-width: 1250px;

    margin: auto;

    background: white;

    padding: 30px;

    border-radius: 22px;

    box-shadow:
        0 10px 35px
        rgba(0,0,0,0.25);
}

/* =========================================================
   TÍTULO
========================================================= */

.encabezado {

    background:
        linear-gradient(
            135deg,
            #18335c,
            #2563a6
        );

    color: white;

    padding: 25px;

    border-radius: 15px;

    text-align: center;

    margin-bottom: 25px;
}

.encabezado h1 {

    font-size: 30px;

    margin-bottom: 8px;
}

.encabezado p {

    opacity: 0.9;

    font-size: 16px;
}

/* =========================================================
   TARJETAS
========================================================= */

.tarjeta {

    background: white;

    border-radius: 15px;

    padding: 20px;

    margin-bottom: 20px;

    border: 1px solid #e2e8f0;
}

/* =========================================================
   TOTAL
========================================================= */

.total {

    background:
        linear-gradient(
            135deg,
            #dcfce7,
            #bbf7d0
        );

    border: 2px solid #22c55e;

    padding: 25px;

    border-radius: 15px;

    text-align: center;

    margin-bottom: 20px;
}

.total h2 {

    color: #166534;

    font-size: 32px;

    margin-bottom: 8px;
}

.total p {

    color: #15803d;

    font-weight: bold;
}

/* =========================================================
   ESTADÍSTICAS
========================================================= */

.estadisticas {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 15px;

    margin-bottom: 20px;
}

.estadistica {

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    padding: 20px;

    border-radius: 12px;

    text-align: center;
}

.estadistica .numero {

    font-size: 25px;

    font-weight: bold;

    color: #18335c;

    margin-top: 8px;
}

/* =========================================================
   FILTROS
========================================================= */

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

    transition: 0.2s;
}

.filtros a:hover {

    transform: translateY(-2px);

    opacity: 0.9;
}

.todos {
    background: #475569;
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

/* =========================================================
   FORMULARIOS
========================================================= */

.formulario-filtros {

    display: grid;

    grid-template-columns:
        1fr auto;

    gap: 10px;
}

.formulario-filtros input {

    width: 100%;

    padding: 12px;

    border: 1px solid #cbd5e1;

    border-radius: 8px;

    font-size: 15px;
}

.formulario-filtros button {

    border: none;

    padding: 12px 20px;

    border-radius: 8px;

    background: #18335c;

    color: white;

    font-weight: bold;

    cursor: pointer;
}

.formulario-filtros button:hover {

    background: #2f5d9f;
}

.busqueda {

    display: grid;

    grid-template-columns:
        1fr auto;

    gap: 10px;
}

.busqueda input {

    width: 100%;

    padding: 12px;

    border: 1px solid #cbd5e1;

    border-radius: 8px;

    font-size: 15px;
}

.busqueda button {

    border: none;

    padding: 12px 20px;

    border-radius: 8px;

    background: #16a34a;

    color: white;

    font-weight: bold;

    cursor: pointer;
}

/* =========================================================
   TABLA
========================================================= */

.tabla-contenedor {

    overflow-x: auto;
}

table {

    width: 100%;

    border-collapse: collapse;

    min-width: 950px;
}

th {

    background: #18335c;

    color: white;

    padding: 14px;

    text-align: center;
}

td {

    padding: 12px;

    text-align: center;

    border-bottom:
        1px solid #e2e8f0;
}

tr:hover {

    background: #f8fafc;
}

.monto {

    color: #15803d;

    font-weight: bold;
}

/* =========================================================
   ACCIONES
========================================================= */

.acciones {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 6px;

    flex-wrap: wrap;
}

.boton {

    display: inline-block;

    text-decoration: none;

    color: white;

    padding: 8px 12px;

    border-radius: 7px;

    font-size: 13px;

    font-weight: bold;
}

.mostrar {

    background: #4da6ff;
}

.editar {

    background: #28a745;
}

.eliminar {

    background: #dc3545;
}

/* =========================================================
   SIN DATOS
========================================================= */

.sin-datos {

    padding: 40px;

    text-align: center;

    color: #64748b;

    font-size: 18px;
}

/* =========================================================
   VOLVER
========================================================= */

.volver {

    display: block;

    width: 250px;

    margin: 25px auto 0;

    text-align: center;

    text-decoration: none;

    background: #18335c;

    color: white;

    padding: 14px;

    border-radius: 10px;

    font-weight: bold;
}

.volver:hover {

    background: #2f5d9f;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 750px) {

    .fondo-panel {

        padding: 15px 10px;
    }

    .contenedor {

        padding: 15px;

        border-radius: 15px;
    }

    .encabezado h1 {

        font-size: 23px;
    }

    .estadisticas {

        grid-template-columns: 1fr;
    }

    .formulario-filtros {

        grid-template-columns: 1fr;
    }

    .busqueda {

        grid-template-columns: 1fr;
    }

    .filtros {

        flex-direction: column;
    }

    .filtros a {

        text-align: center;

        width: 100%;
    }

    .total h2 {

        font-size: 25px;
    }

}

</style>

</head>

<body>

<?php include("../menu.php"); ?>


<main class="fondo-panel">

<div class="contenedor">


<!-- =====================================================
     ENCABEZADO
====================================================== -->

<div class="encabezado">

    <h1>
        💰 REPORTE DE INGRESOS
    </h1>

    <p>
        <?php

        if ($rol == "Administrador") {

            echo "Panel general de ventas";

        } else {

            echo "Reporte de tus ventas";

        }

        ?>
    </p>

</div>


<!-- =====================================================
     FILTROS
====================================================== -->

<div class="tarjeta">

    <h2 style="margin-bottom:15px;">
        📊 Filtrar reporte
    </h2>

    <div class="filtros">

        <a
            class="todos"
            href="ingre-total.php">

            TODOS

        </a>

        <a
            class="dia"
            href="ingre-total.php?tipo=dia&amp;fecha=<?php echo urlencode($fecha); ?>">

            📅 POR DÍA

        </a>

        <a
            class="semana"
            href="ingre-total.php?tipo=semana&amp;fecha=<?php echo urlencode($fecha); ?>">

            📆 POR SEMANA

        </a>

        <a
            class="mes"
            href="ingre-total.php?tipo=mes&amp;fecha=<?php echo urlencode($fecha); ?>">

            🗓️ POR MES

        </a>

        <a
            class="año"
            href="ingre-total.php?tipo=año&amp;fecha=<?php echo urlencode($fecha); ?>">

            📊 POR AÑO

        </a>

    </div>

</div>


<!-- =====================================================
     SELECCIONAR FECHA
====================================================== -->

<div class="tarjeta">

    <h3 style="margin-bottom:12px;">

        📅 Seleccionar fecha

    </h3>

    <form method="GET">

        <div class="formulario-filtros">

            <input
                type="date"
                name="fecha"
                value="<?php echo htmlspecialchars($fecha); ?>"
                required
            >

            <input
                type="hidden"
                name="tipo"
                value="<?php echo htmlspecialchars($tipo); ?>"
            >

            <button type="submit">

                🔎 CONSULTAR

            </button>

        </div>

    </form>

</div>


<!-- =====================================================
     BUSCAR
====================================================== -->

<div class="tarjeta">

    <h3 style="margin-bottom:12px;">

        🔍 Buscar ventas

    </h3>

    <form method="GET">

        <input
            type="hidden"
            name="tipo"
            value="<?php echo htmlspecialchars($tipo); ?>"
        >

        <input
            type="hidden"
            name="fecha"
            value="<?php echo htmlspecialchars($fecha); ?>"
        >

        <div class="busqueda">

            <input
                type="text"
                name="buscar"
                value="<?php echo htmlspecialchars($buscar); ?>"
                placeholder="Cliente, vendedor, método de pago o número de pedido..."
            >

            <button type="submit">

                BUSCAR

            </button>

        </div>

    </form>

</div>


<!-- =====================================================
     TOTAL
====================================================== -->

<div class="total">

    <h2>

        Bs.
        <?php
        echo number_format(
            $totalIngresos,
            2,
            ".",
            ","
        );
        ?>

    </h2>

    <p>

        💰 INGRESOS TOTALES

    </p>

    <p style="margin-top:8px;">

        <?php echo htmlspecialchars($textoFiltro); ?>

    </p>

</div>


<!-- =====================================================
     ESTADÍSTICAS
====================================================== -->

<div class="estadisticas">

    <div class="estadistica">

        <div>
            🧾 VENTAS
        </div>

        <div class="numero">

            <?php echo $cantidadVentas; ?>

        </div>

    </div>


    <div class="estadistica">

        <div>
            💵 PROMEDIO POR VENTA
        </div>

        <div class="numero">

            Bs.
            <?php

            if ($cantidadVentas > 0) {

                echo number_format(
                    $totalIngresos / $cantidadVentas,
                    2,
                    ".",
                    ","
                );

            } else {

                echo "0.00";
            }

            ?>

        </div>

    </div>

</div>


<!-- =====================================================
     TABLA
====================================================== -->

<div class="tarjeta">

    <h2 style="margin-bottom:15px;">

        📋 Detalle de ingresos

    </h2>


    <div class="tabla-contenedor">

        <?php if ($resultado->num_rows > 0) { ?>

        <table>

            <tr>

                <th>ID</th>

                <th>Pedido</th>

                <th>Cliente</th>

                <th>Vendedor</th>

                <th>Fecha</th>

                <th>Total</th>

                <th>Pago</th>

                <th>Acciones</th>

            </tr>


            <?php while ($fila = $resultado->fetch_assoc()) { ?>

            <tr>

                <!-- ID -->

                <td>

                    <?php

                    echo htmlspecialchars(
                        $fila['id']
                    );

                    ?>

                </td>


                <!-- PEDIDO -->

                <td>

                    #<?php

                    echo htmlspecialchars(
                        $fila['pedidos_id']
                    );

                    ?>

                </td>


                <!-- CLIENTE -->

                <td>

                    <?php

                    echo htmlspecialchars(
                        $fila['cliente']
                    );

                    ?>

                </td>


                <!-- VENDEDOR -->

                <td>

                    <?php

                    echo htmlspecialchars(
                        $fila['nombrevendedor']
                    );

                    ?>

                </td>


                <!-- FECHA -->

                <td>

                    <?php

                    echo date(
                        "d/m/Y H:i",
                        strtotime($fila['fecha'])
                    );

                    ?>

                </td>


                <!-- TOTAL -->

                <td class="monto">

                    Bs.

                    <?php

                    echo number_format(
                        floatval($fila['total']),
                        2,
                        ".",
                        ","
                    );

                    ?>

                </td>


                <!-- MÉTODO DE PAGO -->

                <td>

                    <?php

                    echo htmlspecialchars(
                        $fila['metodo_pago']
                    );

                    ?>

                </td>


                <!-- ACCIONES -->

                <td>

                    <div class="acciones">

                        <!-- DETALLE -->

                        <a
                            class="boton mostrar"
                            href="../pedidos/detallePedido.php?id=<?php echo urlencode($fila['pedidos_id']); ?>"
                        >

                            👁️ Detalle

                        </a>


                        <?php if ($rol == "Administrador") { ?>

                        <!-- EDITAR -->

                        <a
                            class="boton editar"
                            href="editarVenta.php?id=<?php echo urlencode($fila['id']); ?>"
                        >

                            ✏️ Editar

                        </a>


                        <!-- ELIMINAR -->

                        <a
                            class="boton eliminar"
                            href="eliminarVenta.php?id=<?php echo urlencode($fila['id']); ?>"
                            onclick="return confirm(
                                '¿Está seguro de eliminar esta venta?'
                            );"
                        >

                            🗑️ Eliminar

                        </a>

                        <?php } ?>

                    </div>

                </td>

            </tr>

            <?php } ?>

        </table>

        <?php } else { ?>

        <div class="sin-datos">

            📭

            <br><br>

            <strong>
                No hay ventas para este período.
            </strong>

            <br>

            Intenta seleccionar otra fecha o filtro.

        </div>

        <?php } ?>

    </div>

</div>


<!-- =====================================================
     VOLVER
====================================================== -->

<?php if ($rol == "Administrador") { ?>

<a
    href="../paginaprincipal/02.admin.php"
    class="volver"
>

    ⬅️ Volver al panel

</a>

<?php } else { ?>

<a
    href="../paginaprincipal/vendedor20.php"
    class="volver"
>

    ⬅️ Volver al panel

</a>

<?php } ?>


</div>

</main>


<?php include("../paginaprincipal/piedepagina.php"); ?>


</body>

</html>
