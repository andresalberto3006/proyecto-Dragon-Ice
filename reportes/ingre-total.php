<?php

// ==========================================
// REPORTE DE INGRESOS - EDSON
// Archivo único: index.php
// ==========================================

// Archivo donde se guardarán los ingresos
$archivo = "ingresos.json";

// Cargar ingresos existentes
$ingresos = [];

if (file_exists($archivo)) {
    $contenido = file_get_contents($archivo);
    $ingresos = json_decode($contenido, true) ?? [];
}

// ==========================================
// REGISTRAR INGRESO
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["guardar"])) {

        $fecha = $_POST["fecha"] ?? "";
        $descripcion = trim($_POST["descripcion"] ?? "");
        $monto = floatval($_POST["monto"] ?? 0);

        if ($fecha !== "" && $descripcion !== "" && $monto > 0) {

            $nuevoId = 1;

            if (count($ingresos) > 0) {
                $ids = array_column($ingresos, "id");
                $nuevoId = max($ids) + 1;
            }

            $nuevoIngreso = [
                "id" => $nuevoId,
                "fecha" => $fecha,
                "descripcion" => $descripcion,
                "monto" => $monto
            ];

            $ingresos[] = $nuevoIngreso;

            file_put_contents(
                $archivo,
                json_encode($ingresos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            header("Location: index.php");
            exit;
        }
    }

    // ==========================================
    // ELIMINAR INGRESO
    // ==========================================

    if (isset($_POST["eliminar"])) {

        $idEliminar = intval($_POST["id"]);

        $ingresos = array_filter(
            $ingresos,
            function ($ingreso) use ($idEliminar) {
                return $ingreso["id"] != $idEliminar;
            }
        );

        $ingresos = array_values($ingresos);

        file_put_contents(
            $archivo,
            json_encode($ingresos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        header("Location: index.php");
        exit;
    }
}

// ==========================================
// FILTROS
// ==========================================

$tipo = $_GET["tipo"] ?? "todos";
$fechaSeleccionada = $_GET["fecha"] ?? date("Y-m-d");

$resultados = $ingresos;

// ==========================================
// FILTRO POR DÍA
// ==========================================

if ($tipo === "dia") {

    $resultados = array_filter(
        $ingresos,
        function ($ingreso) use ($fechaSeleccionada) {
            return $ingreso["fecha"] === $fechaSeleccionada;
        }
    );
}

// ==========================================
// FILTRO POR SEMANA
// ==========================================

if ($tipo === "semana") {

    $fecha = new DateTime($fechaSeleccionada);

    $diaSemana = (int)$fecha->format("N");

    $inicioSemana = clone $fecha;
    $inicioSemana->modify("-" . ($diaSemana - 1) . " days");

    $finSemana = clone $inicioSemana;
    $finSemana->modify("+6 days");

    $resultados = array_filter(
        $ingresos,
        function ($ingreso) use ($inicioSemana, $finSemana) {

            $fechaIngreso = new DateTime($ingreso["fecha"]);

            return $fechaIngreso >= $inicioSemana &&
                   $fechaIngreso <= $finSemana;
        }
    );
}

// ==========================================
// FILTRO POR MES
// ==========================================

if ($tipo === "mes") {

    $fecha = new DateTime($fechaSeleccionada);

    $mes = $fecha->format("m");
    $año = $fecha->format("Y");

    $resultados = array_filter(
        $ingresos,
        function ($ingreso) use ($mes, $año) {

            $fechaIngreso = new DateTime($ingreso["fecha"]);

            return $fechaIngreso->format("m") === $mes &&
                   $fechaIngreso->format("Y") === $año;
        }
    );
}

// ==========================================
// FILTRO POR AÑO
// ==========================================

if ($tipo === "año") {

    $fecha = new DateTime($fechaSeleccionada);

    $año = $fecha->format("Y");

    $resultados = array_filter(
        $ingresos,
        function ($ingreso) use ($año) {

            $fechaIngreso = new DateTime($ingreso["fecha"]);

            return $fechaIngreso->format("Y") === $año;
        }
    );
}

// ==========================================
// CALCULAR TOTAL
// ==========================================

$total = 0;

foreach ($resultados as $ingreso) {
    $total += floatval($ingreso["monto"]);
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reporte de Ingresos - EDSON</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .contenedor {
            width: 95%;
            max-width: 1100px;
            margin: 30px auto;
        }

        .titulo {
            background: #1d4ed8;
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
        }

        .titulo h1 {
            margin: 0;
        }

        .formulario {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .formulario h2 {
            margin-top: 0;
        }

        .campos {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr auto;
            gap: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
        }

        button {
            border: none;
            padding: 12px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-guardar {
            background: #16a34a;
            color: white;
        }

        .btn-guardar:hover {
            background: #15803d;
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .filtros a {
            text-decoration: none;
            color: white;
            padding: 12px 20px;
            border-radius: 7px;
            font-weight: bold;
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

        .total {
            background: #dcfce7;
            border: 2px solid #16a34a;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
        }

        .total h2 {
            margin: 0;
            color: #166534;
        }

        .tabla-contenedor {
            background: white;
            padding: 20px;
            border-radius: 12px;
            overflow-x: auto;
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
        }

        tr:hover {
            background: #f8fafc;
        }

        .eliminar {
            background: #dc2626;
            color: white;
            padding: 7px 12px;
        }

        .sin-datos {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        @media (max-width: 800px) {

            .campos {
                grid-template-columns: 1fr;
            }

            .filtros {
                flex-direction: column;
            }

            .filtros a {
                text-align: center;
            }
        }

    </style>

</head>

<body>

<div class="contenedor">

    <!-- ======================================
         TÍTULO
    ======================================= -->

    <div class="titulo">

        <h1>REPORTE DE INGRESOS</h1>

        <p>EDSON</p>

    </div>


    <!-- ======================================
         FORMULARIO DE REGISTRO
    ======================================= -->

    <div class="formulario">

        <h2>Registrar nuevo ingreso</h2>

        <form method="POST">

            <div class="campos">

                <input
                    type="date"
                    name="fecha"
                    value="<?= date("Y-m-d") ?>"
                    required
                >

                <input
                    type="text"
                    name="descripcion"
                    placeholder="Descripción del ingreso"
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


    <!-- ======================================
         FILTROS
    ======================================= -->

    <div class="filtros">

        <a
            class="todos"
            href="index.php">

            TODOS

        </a>

        <a
            class="dia"
            href="index.php?tipo=dia&fecha=<?= $fechaSeleccionada ?>">

            POR DÍA

        </a>

        <a
            class="semana"
            href="index.php?tipo=semana&fecha=<?= $fechaSeleccionada ?>">

            POR SEMANA

        </a>

        <a
            class="mes"
            href="index.php?tipo=mes&fecha=<?= $fechaSeleccionada ?>">

            POR MES

        </a>

        <a
            class="año"
            href="index.php?tipo=año&fecha=<?= $fechaSeleccionada ?>">

            POR AÑO

        </a>

    </div>


    <!-- ======================================
         SELECCIONAR FECHA
    ======================================= -->

    <div class="formulario">

        <form method="GET">

            <label>

                <strong>Seleccionar fecha para el reporte:</strong>

            </label>

            <br><br>

            <input
                type="date"
                name="fecha"
                value="<?= htmlspecialchars($fechaSeleccionada) ?>"
                required
            >

            <input
                type="hidden"
                name="tipo"
                value="<?= htmlspecialchars($tipo) ?>"
            >

            <button
                type="submit"
                class="btn-guardar">

                CONSULTAR

            </button>

        </form>

    </div>


    <!-- ======================================
         TOTAL
    ======================================= -->

    <div class="total">

        <h2>

            TOTAL:

            Bs.
            <?= number_format($total, 2) ?>

        </h2>

    </div>


    <!-- ======================================
         TABLA
    ======================================= -->

    <div class="tabla-contenedor">

        <h2>Detalle de ingresos</h2>

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

                    <tr>

                        <td>
                            <?= $ingreso["id"] ?>
                        </td>

                        <td>
                            <?= date(
                                "d/m/Y",
                                strtotime($ingreso["fecha"])
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $ingreso["descripcion"]
                            ) ?>
                        </td>

                        <td>
                            Bs.
                            <?= number_format(
                                $ingreso["monto"],
                                2
                            ) ?>
                        </td>

                        <td>

                            <form method="POST">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $ingreso["id"] ?>"
                                >

                                <button
                                    type="submit"
                                    name="eliminar"
                                    class="eliminar"
                                    onclick="return confirm(
                                        '¿Está seguro de eliminar este ingreso?'
                                    );">

                                    ELIMINAR

                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        <?php else: ?>

            <div class="sin-datos">

                No existen ingresos registrados para este período.

            </div>

        <?php endif; ?>

    </div>

</div>

</body>

</html>