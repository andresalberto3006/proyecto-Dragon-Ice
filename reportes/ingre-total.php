<?php

session_start();

// ==========================================================
// CONEXIÓN A LA BASE DE DATOS
// ==========================================================

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "dragonice";

$conn = new mysqli(
    $servidor,
    $usuario,
    $contrasena,
    $bd
);

if ($conn->connect_error) {

    die(
        "Error de conexión: " .
        $conn->connect_error
    );
}

$conn->set_charset("utf8mb4");


// ==========================================================
// SESIÓN
// ==========================================================

$ci = isset($_SESSION["ci"])
    ? $_SESSION["ci"]
    : "";


// ==========================================================
// TOP 3 PRODUCTOS MÁS VENDIDOS
// ==========================================================

$sqlProductos = "
    SELECT
        productos.nombre,
        SUM(carrito.cantidad) AS cantidad

    FROM carrito

    INNER JOIN productos
        ON carrito.productos_id = productos.id

    INNER JOIN ventas
        ON carrito.pedidos_id = ventas.pedidos_id

    GROUP BY
        productos.id,
        productos.nombre

    ORDER BY cantidad DESC

    LIMIT 3
";


$resultadoProductos =
    $conn->query($sqlProductos);


$productosGrafico = array();
$cantidadesGrafico = array();


if ($resultadoProductos !== false) {

    while (
        $fila =
        $resultadoProductos->fetch_assoc()
    ) {

        $productosGrafico[] =
            $fila["nombre"];

        $cantidadesGrafico[] =
            intval($fila["cantidad"]);

    }

}


// ==========================================================
// REPORTE DE INGRESOS
// Archivo: ingre-total.php
// ==========================================================


// ==========================================================
// CONFIGURACIÓN DEL ARCHIVO JSON
// ==========================================================

$archivo =
    __DIR__ .
    DIRECTORY_SEPARATOR .
    "ingresos.json";


// Nombre del archivo actual

$paginaActual =
    basename(__FILE__);


// ==========================================================
// CARGAR INGRESOS
// ==========================================================

$ingresos = array();


if (file_exists($archivo)) {

    $contenido =
        file_get_contents($archivo);


    if (
        $contenido !== false &&
        trim($contenido) !== ""
    ) {

        $datos =
            json_decode(
                $contenido,
                true
            );


        if (is_array($datos)) {

            $ingresos = $datos;

        }
    }
}


// ==========================================================
// FUNCIÓN PARA GUARDAR JSON
// ==========================================================

function guardarIngresos(
    $archivo,
    $ingresos
) {

    $json = json_encode(
        $ingresos,
        JSON_PRETTY_PRINT |
        JSON_UNESCAPED_UNICODE
    );


    file_put_contents(
        $archivo,
        $json
    );

}


// ==========================================================
// FUNCIÓN PARA VOLVER A LA PÁGINA
// ==========================================================

function volverPagina(
    $paginaActual
) {

    header(
        "Location: " .
        $paginaActual
    );

    exit;

}


// ==========================================================
// PROCESAR FORMULARIOS
// ==========================================================

if (
    $_SERVER["REQUEST_METHOD"] ==
    "POST"
) {


    // ======================================================
    // GUARDAR NUEVO INGRESO
    // ======================================================

    if (
        isset($_POST["guardar"])
    ) {

        $fecha =
            isset($_POST["fecha"])
            ? trim($_POST["fecha"])
            : "";


        $descripcion =
            isset($_POST["descripcion"])
            ? trim($_POST["descripcion"])
            : "";


        $monto =
            isset($_POST["monto"])
            ? floatval($_POST["monto"])
            : 0;


        if (

            $fecha != "" &&
            $descripcion != "" &&
            $monto > 0

        ) {


            // Buscar el ID más alto

            $mayorId = 0;


            foreach (
                $ingresos as $ingreso
            ) {

                if (
                    isset(
                        $ingreso["id"]
                    )
                ) {

                    $id =
                        intval(
                            $ingreso["id"]
                        );


                    if (
                        $id > $mayorId
                    ) {

                        $mayorId =
                            $id;

                    }
                }
            }


            // Nuevo ID

            $nuevoId =
                $mayorId + 1;


            // Crear nuevo ingreso

            $nuevoIngreso =
                array(

                    "id" =>
                        $nuevoId,

                    "fecha" =>
                        $fecha,

                    "descripcion" =>
                        $descripcion,

                    "monto" =>
                        $monto

                );


            $ingresos[] =
                $nuevoIngreso;


            guardarIngresos(
                $archivo,
                $ingresos
            );


            volverPagina(
                $paginaActual
            );

        }

    }



    // ======================================================
    // EDITAR INGRESO
    // ======================================================

    if (
        isset($_POST["editar"])
    ) {

        $idEditar =
            isset($_POST["id"])
            ? intval($_POST["id"])
            : 0;


        $fecha =
            isset($_POST["fecha"])
            ? trim($_POST["fecha"])
            : "";


        $descripcion =
            isset($_POST["descripcion"])
            ? trim($_POST["descripcion"])
            : "";


        $monto =
            isset($_POST["monto"])
            ? floatval($_POST["monto"])
            : 0;


        if (

            $idEditar > 0 &&
            $fecha != "" &&
            $descripcion != "" &&
            $monto > 0

        ) {


            foreach (
                $ingresos as
                $indice =>
                $ingreso
            ) {

                if (

                    isset(
                        $ingreso["id"]
                    ) &&

                    intval(
                        $ingreso["id"]
                    ) == $idEditar

                ) {


                    $ingresos[$indice]["fecha"] =
                        $fecha;


                    $ingresos[$indice]["descripcion"] =
                        $descripcion;


                    $ingresos[$indice]["monto"] =
                        $monto;


                    break;

                }
            }


            guardarIngresos(
                $archivo,
                $ingresos
            );


            volverPagina(
                $paginaActual
            );

        }

    }



    // ======================================================
    // ELIMINAR INGRESO
    // ======================================================

    if (
        isset($_POST["eliminar"])
    ) {

        $idEliminar =
            isset($_POST["id"])
            ? intval($_POST["id"])
            : 0;


        $nuevosIngresos =
            array();


        foreach (
            $ingresos as $ingreso
        ) {

            if (

                !isset(
                    $ingreso["id"]
                ) ||

                intval(
                    $ingreso["id"]
                ) != $idEliminar

            ) {

                $nuevosIngresos[] =
                    $ingreso;

            }
        }


        $ingresos =
            $nuevosIngresos;


        guardarIngresos(
            $archivo,
            $ingresos
        );


        volverPagina(
            $paginaActual
        );

    }

}


// ==========================================================
// FILTROS
// ==========================================================

$tipo =
    isset($_GET["tipo"])
    ? $_GET["tipo"]
    : "todos";


$fechaSeleccionada =
    isset($_GET["fecha"])
    ? $_GET["fecha"]
    : date("Y-m-d");


$busqueda =
    isset($_GET["buscar"])
    ? trim($_GET["buscar"])
    : "";


// Resultados iniciales

$resultados =
    $ingresos;


// ==========================================================
// FILTRO POR DÍA
// ==========================================================

if (
    $tipo == "dia"
) {

    $resultados =
        array_filter(

            $resultados,

            function (
                $ingreso
            ) use (
                $fechaSeleccionada
            ) {

                if (
                    !isset(
                        $ingreso["fecha"]
                    )
                ) {

                    return false;

                }


                return
                    $ingreso["fecha"]
                    ==
                    $fechaSeleccionada;

            }

        );

}


// ==========================================================
// FILTRO POR SEMANA
// ==========================================================

if (
    $tipo == "semana"
) {

    try {

        $fecha =
            new DateTime(
                $fechaSeleccionada
            );


        $diaSemana =
            intval(
                $fecha->format("N")
            );


        $inicioSemana =
            clone $fecha;


        $inicioSemana->modify(

            "-" .
            ($diaSemana - 1) .
            " days"

        );


        $finSemana =
            clone $inicioSemana;


        $finSemana->modify(
            "+6 days"
        );


        $inicioTexto =
            $inicioSemana->format(
                "Y-m-d"
            );


        $finTexto =
            $finSemana->format(
                "Y-m-d"
            );


        $resultados =
            array_filter(

                $resultados,

                function (
                    $ingreso
                ) use (

                    $inicioTexto,
                    $finTexto

                ) {

                    if (
                        !isset(
                            $ingreso["fecha"]
                        )
                    ) {

                        return false;

                    }


                    return

                        $ingreso["fecha"]
                        >=
                        $inicioTexto

                        &&

                        $ingreso["fecha"]
                        <=
                        $finTexto;

                }

            );

    }
    catch (
        Exception $e
    ) {

        $resultados =
            array();

    }

}


// ==========================================================
// FILTRO POR MES
// ==========================================================

if (
    $tipo == "mes"
) {

    try {

        $fecha =
            new DateTime(
                $fechaSeleccionada
            );


        $mes =
            $fecha->format("m");


        $anio =
            $fecha->format("Y");


        $resultados =
            array_filter(

                $resultados,

                function (
                    $ingreso
                ) use (

                    $mes,
                    $anio

                ) {

                    if (
                        !isset(
                            $ingreso["fecha"]
                        )
                    ) {

                        return false;

                    }


                    try {

                        $fechaIngreso =
                            new DateTime(
                                $ingreso["fecha"]
                            );


                        return

                            $fechaIngreso->format("m")
                            ==
                            $mes

                            &&

                            $fechaIngreso->format("Y")
                            ==
                            $anio;

                    }
                    catch (
                        Exception $e
                    ) {

                        return false;

                    }

                }

            );

    }
    catch (
        Exception $e
    ) {

        $resultados =
            array();

    }

}


// ==========================================================
// FILTRO POR AÑO
// ==========================================================

if (
    $tipo == "año"
) {

    try {

        $fecha =
            new DateTime(
                $fechaSeleccionada
            );


        $anio =
            $fecha->format("Y");


        $resultados =
            array_filter(

                $resultados,

                function (
                    $ingreso
                ) use (
                    $anio
                ) {

                    if (
                        !isset(
                            $ingreso["fecha"]
                        )
                    ) {

                        return false;

                    }


                    try {

                        $fechaIngreso =
                            new DateTime(
                                $ingreso["fecha"]
                            );


                        return

                            $fechaIngreso->format("Y")
                            ==
                            $anio;

                    }
                    catch (
                        Exception $e
                    ) {

                        return false;

                    }

                }

            );

    }
    catch (
        Exception $e
    ) {

        $resultados =
            array();

    }

}


// ==========================================================
// FILTRO DE BÚSQUEDA
// ==========================================================

if (
    $busqueda != ""
) {

    $resultados =
        array_filter(

            $resultados,

            function (
                $ingreso
            ) use (
                $busqueda
            ) {

                if (
                    !isset(
                        $ingreso["descripcion"]
                    )
                ) {

                    return false;

                }


                return

                    stripos(

                        $ingreso["descripcion"],

                        $busqueda

                    )

                    !==

                    false;

            }

        );

}


// ==========================================================
// REINDEXAR RESULTADOS
// ==========================================================

$resultados =
    array_values(
        $resultados
    );


// ==========================================================
// ORDENAR TABLA DEL MÁS RECIENTE
// ==========================================================

usort(

    $resultados,

    function (
        $a,
        $b
    ) {

        $fechaA =
            isset($a["fecha"])
            ? $a["fecha"]
            : "";


        $fechaB =
            isset($b["fecha"])
            ? $b["fecha"]
            : "";


        return
            strcmp(
                $fechaB,
                $fechaA
            );

    }

);


// ==========================================================
// CALCULAR TOTAL
// ==========================================================

$total = 0;


foreach (
    $resultados as $ingreso
) {

    if (
        isset(
            $ingreso["monto"]
        )
    ) {

        $total +=
            floatval(
                $ingreso["monto"]
            );

    }
}


// ==========================================================
// DATOS PARA GRÁFICO DE INGRESOS
// ==========================================================

// Agrupar ingresos por fecha

$ingresosPorFecha =
    array();


foreach (
    $resultados as $ingreso
) {

    if (

        isset(
            $ingreso["fecha"]
        )

        &&

        isset(
            $ingreso["monto"]
        )

    ) {


        $fecha =
            $ingreso["fecha"];


        $monto =
            floatval(
                $ingreso["monto"]
            );


        if (
            !isset(
                $ingresosPorFecha[$fecha]
            )
        ) {

            $ingresosPorFecha[$fecha] =
                0;

        }


        $ingresosPorFecha[$fecha] +=
            $monto;

    }

}


// Ordenar fechas

ksort(
    $ingresosPorFecha
);


// Arrays para Chart.js

$fechasGrafico =
    array_keys(
        $ingresosPorFecha
    );


$montosGrafico =
    array_values(
        $ingresosPorFecha
    );


// ==========================================================
// TEXTO DEL FILTRO
// ==========================================================

$textoFiltro =
    "Todos los ingresos";


if (
    $tipo == "dia"
) {

    $textoFiltro =
        "Ingresos del día";

}


if (
    $tipo == "semana"
) {

    $textoFiltro =
        "Ingresos de la semana";

}


if (
    $tipo == "mes"
) {

    $textoFiltro =
        "Ingresos del mes";

}


if (
    $tipo == "año"
) {

    $textoFiltro =
        "Ingresos del año";

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <title>
        Reporte de Ingresos
    </title>


    <!-- CHART.JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>


    <style>

        * {
            box-sizing:
                border-box;
        }


        body {

            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background:
                #eef2f7;

            color:
                #1e293b;

        }


        .contenedor {

            width:
                95%;

            max-width:
                1150px;

            margin:
                25px auto;

        }


        /* =================================================
           CABECERA
        ================================================= */

        .titulo {

            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #2563eb
                );

            color:
                white;

            padding:
                30px 20px;

            border-radius:
                15px;

            text-align:
                center;

            margin-bottom:
                20px;

            box-shadow:
                0 5px 15px
                rgba(
                    0,
                    0,
                    0,
                    0.12
                );

        }


        .titulo h1 {

            margin:
                0;

            font-size:
                30px;

        }


        .titulo p {

            margin:
                8px 0 0;

            font-size:
                18px;

        }


        /* =================================================
           CONTENEDORES
        ================================================= */

        .formulario,
        .filtros,
        .tabla-contenedor,
        .grafico-contenedor {

            background:
                white;

            padding:
                20px;

            border-radius:
                14px;

            box-shadow:
                0 3px 12px
                rgba(
                    0,
                    0,
                    0,
                    0.07
                );

            margin-bottom:
                20px;

        }


        /* =================================================
           CAMPOS
        ================================================= */

        .campos {

            display:
                grid;

            grid-template-columns:
                1fr
                2fr
                1fr
                auto;

            gap:
                10px;

        }


        input {

            width:
                100%;

            padding:
                12px;

            border:
                1px solid
                #cbd5e1;

            border-radius:
                8px;

            font-size:
                15px;

        }


        /* =================================================
           BOTONES
        ================================================= */

        button {

            border:
                none;

            padding:
                12px 18px;

            border-radius:
                8px;

            cursor:
                pointer;

            font-weight:
                bold;

        }


        .btn-guardar {

            background:
                #16a34a;

            color:
                white;

        }


        .btn-editar {

            background:
                #2563eb;

            color:
                white;

            padding:
                8px 12px;

        }


        .btn-eliminar {

            background:
                #dc2626;

            color:
                white;

            padding:
                8px 12px;

        }


        .btn-cancelar {

            background:
                #64748b;

            color:
                white;

        }


        /* =================================================
           FILTROS
        ================================================= */

        .filtros {

            display:
                flex;

            flex-wrap:
                wrap;

            gap:
                10px;

        }


        .filtros a {

            text-decoration:
                none;

            color:
                white;

            padding:
                12px 18px;

            border-radius:
                8px;

            font-weight:
                bold;

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


        /* =================================================
           BUSCADOR
        ================================================= */

        .buscador {

            display:
                grid;

            grid-template-columns:
                1fr auto;

            gap:
                10px;

        }


        /* =================================================
           TOTAL
        ================================================= */

        .total {

            background:
                linear-gradient(
                    135deg,
                    #dcfce7,
                    #bbf7d0
                );

            border:
                2px solid
                #16a34a;

            padding:
                25px;

            border-radius:
                14px;

            text-align:
                center;

            margin-bottom:
                20px;

        }


        .total h2 {

            margin:
                0;

            color:
                #166534;

            font-size:
                27px;

        }


        .subtitulo-total {

            margin-top:
                8px;

            color:
                #15803d;

        }


        /* =================================================
           GRÁFICOS
        ================================================= */

        .grafico-contenedor h2 {

            margin-top:
                0;

        }


        .grafico-contenedor canvas {

            width:
                100% !important;

            max-height:
                400px;

        }


        /* =================================================
           TABLA
        ================================================= */

        .tabla-contenedor {

            overflow-x:
                auto;

        }


        .tabla-titulo {

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                center;

            margin-bottom:
                15px;

        }


        table {

            width:
                100%;

            border-collapse:
                collapse;

        }


        th {

            background:
                #1e293b;

            color:
                white;

            padding:
                14px;

            text-align:
                left;

        }


        td {

            padding:
                12px;

            border-bottom:
                1px solid
                #e2e8f0;

        }


        .monto {

            font-weight:
                bold;

            color:
                #15803d;

        }


        .acciones {

            display:
                flex;

            gap:
                6px;

        }


        /* =================================================
           SIN DATOS
        ================================================= */

        .sin-datos {

            text-align:
                center;

            padding:
                40px;

            color:
                #64748b;

        }


        /* =================================================
           MODAL
        ================================================= */

        .modal {

            display:
                none;

            position:
                fixed;

            z-index:
                1000;

            left:
                0;

            top:
                0;

            width:
                100%;

            height:
                100%;

            background:
                rgba(
                    15,
                    23,
                    42,
                    0.65
                );

            padding:
                20px;

        }


        .modal-contenido {

            background:
                white;

            max-width:
                500px;

            margin:
                70px auto;

            padding:
                25px;

            border-radius:
                15px;

        }


        .campo-modal {

            margin-bottom:
                15px;

        }


        .campo-modal label {

            display:
                block;

            font-weight:
                bold;

            margin-bottom:
                6px;

        }


        .botones-modal {

            display:
                flex;

            gap:
                10px;

            justify-content:
                flex-end;

            margin-top:
                20px;

        }


        /* =================================================
           RESPONSIVE
        ================================================= */

        @media (
            max-width: 800px
        ) {

            .campos {

                grid-template-columns:
                    1fr;

            }


            .filtros {

                flex-direction:
                    column;

            }


            .filtros a {

                width:
                    100%;

                text-align:
                    center;

            }


            .buscador {

                grid-template-columns:
                    1fr;

            }


            .tabla-titulo {

                flex-direction:
                    column;

                align-items:
                    flex-start;

            }


            .acciones {

                flex-direction:
                    column;

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

        <h1>
            REPORTE DE INGRESOS
        </h1>

        <p>
            DRAGON ICE
        </p>

    </div>



    <!-- ==================================================
         REGISTRAR INGRESO
    =================================================== -->

    <div class="formulario">

        <h2>
            ➕ Registrar nuevo ingreso
        </h2>


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
                    class="btn-guardar"
                >

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
            href="<?php echo $paginaActual; ?>"
        >
            TODOS
        </a>


        <a
            class="dia"
            href="<?php echo $paginaActual; ?>?tipo=dia&fecha=<?php echo urlencode($fechaSeleccionada); ?>"
        >
            📅 POR DÍA
        </a>


        <a
            class="semana"
            href="<?php echo $paginaActual; ?>?tipo=semana&fecha=<?php echo urlencode($fechaSeleccionada); ?>"
        >
            📆 POR SEMANA
        </a>


        <a
            class="mes"
            href="<?php echo $paginaActual; ?>?tipo=mes&fecha=<?php echo urlencode($fechaSeleccionada); ?>"
        >
            🗓️ POR MES
        </a>


        <a
            class="año"
            href="<?php echo $paginaActual; ?>?tipo=año&fecha=<?php echo urlencode($fechaSeleccionada); ?>"
        >
            📊 POR AÑO
        </a>


    </div>



    <!-- ==================================================
         SELECCIONAR FECHA
    =================================================== -->

    <div class="formulario">


        <form method="GET">


            <strong>
                Seleccionar fecha:
            </strong>


            <br>
            <br>


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


            <br>
            <br>


            <button
                type="submit"
                class="btn-guardar"
            >
                🔎 CONSULTAR
            </button>


        </form>

    </div>



    <!-- ==================================================
         BUSCADOR
    =================================================== -->

    <div class="formulario">

        <h2>
            🔍 Buscar ingreso
        </h2>


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
                    class="btn-guardar"
                >
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
            <?php
                echo number_format(
                    $total,
                    2
                );
            ?>

        </h2>


        <div class="subtitulo-total">

            <?php
                echo htmlspecialchars(
                    $textoFiltro
                );
            ?>


            <?php if ($busqueda != ""): ?>

                —
                búsqueda:
                "<?php
                    echo htmlspecialchars(
                        $busqueda
                    );
                ?>"

            <?php endif; ?>


        </div>

    </div>



    <!-- ==================================================
         GRÁFICO DE INGRESOS
    =================================================== -->

    <div class="grafico-contenedor">

        <h2>
            📈 Evolución de ingresos
        </h2>


        <canvas
            id="graficoIngresos"
        >
        </canvas>

    </div>



    <!-- ==================================================
         TOP PRODUCTOS
    =================================================== -->

    <div class="grafico-contenedor">

        <h2>
            🏆 Top 3 productos más vendidos
        </h2>


        <canvas
            id="graficoProductos"
        >
        </canvas>

    </div>



    <!-- ==================================================
         TABLA
    =================================================== -->

    <div class="tabla-contenedor">


        <div class="tabla-titulo">


            <h2>
                Detalle de ingresos
            </h2>


            <strong>

                Registros:

                <?php
                    echo count(
                        $resultados
                    );
                ?>

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


                <?php
                foreach (
                    $resultados as
                    $ingreso
                ):
                ?>


                    <?php

                    $idIngreso =
                        isset(
                            $ingreso["id"]
                        )
                        ? intval(
                            $ingreso["id"]
                        )
                        : 0;


                    $fechaIngreso =
                        isset(
                            $ingreso["fecha"]
                        )
                        ? $ingreso["fecha"]
                        : "";


                    $descripcionIngreso =
                        isset(
                            $ingreso["descripcion"]
                        )
                        ? $ingreso["descripcion"]
                        : "";


                    $montoIngreso =
                        isset(
                            $ingreso["monto"]
                        )
                        ? floatval(
                            $ingreso["monto"]
                        )
                        : 0;

                    ?>


                    <tr>


                        <td>

                            <?php
                                echo $idIngreso;
                            ?>

                        </td>



                        <td>

                            <?php

                            if (
                                $fechaIngreso != ""
                            ) {

                                echo date(
                                    "d/m/Y",
                                    strtotime(
                                        $fechaIngreso
                                    )
                                );

                            }

                            ?>

                        </td>



                        <td>

                            <?php

                            echo htmlspecialchars(
                                $descripcionIngreso
                            );

                            ?>

                        </td>



                        <td class="monto">

                            Bs.

                            <?php

                            echo number_format(
                                $montoIngreso,
                                2
                            );

                            ?>

                        </td>



                        <td>


                            <div class="acciones">


                                <button
                                    type="button"
                                    class="btn-editar"
                                    onclick='abrirEditar(
                                        <?php echo json_encode($idIngreso); ?>,
                                        <?php echo json_encode($fechaIngreso); ?>,
                                        <?php echo json_encode($descripcionIngreso); ?>,
                                        <?php echo json_encode($montoIngreso); ?>
                                    );'
                                >

                                    ✏️ EDITAR

                                </button>



                                <form
                                    method="POST"
                                >


                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $idIngreso; ?>"
                                    >


                                    <button
                                        type="submit"
                                        name="eliminar"
                                        class="btn-eliminar"
                                        onclick="return confirm('¿Está seguro de eliminar este ingreso?');"
                                    >

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

                <strong>
                    📭 No existen ingresos
                </strong>

                <br>

                No hay ingresos registrados
                para este período.


            </div>


        <?php endif; ?>


    </div>


</div>



<!-- ======================================================
     MODAL EDITAR
======================================================= -->

<div
    id="modalEditar"
    class="modal"
>


    <div class="modal-contenido">


        <h2>
            ✏️ Editar ingreso
        </h2>


        <form method="POST">


            <input
                type="hidden"
                name="id"
                id="editarId"
            >



            <div class="campo-modal">


                <label>
                    Fecha
                </label>


                <input
                    type="date"
                    name="fecha"
                    id="editarFecha"
                    required
                >


            </div>



            <div class="campo-modal">


                <label>
                    Descripción
                </label>


                <input
                    type="text"
                    name="descripcion"
                    id="editarDescripcion"
                    maxlength="150"
                    required
                >


            </div>



            <div class="campo-modal">


                <label>
                    Monto en Bs.
                </label>


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
                    onclick="cerrarEditar();"
                >

                    CANCELAR

                </button>



                <button
                    type="submit"
                    name="editar"
                    class="btn-guardar"
                >

                    💾 GUARDAR CAMBIOS

                </button>


            </div>


        </form>


    </div>


</div>



<!-- ======================================================
     JAVASCRIPT MODAL
======================================================= -->

<script>


function abrirEditar(
    id,
    fecha,
    descripcion,
    monto
) {

    document
        .getElementById(
            "editarId"
        )
        .value =
        id;


    document
        .getElementById(
            "editarFecha"
        )
        .value =
        fecha;


    document
        .getElementById(
            "editarDescripcion"
        )
        .value =
        descripcion;


    document
        .getElementById(
            "editarMonto"
        )
        .value =
        monto;


    document
        .getElementById(
            "modalEditar"
        )
        .style.display =
        "block";

}



function cerrarEditar()
{

    document
        .getElementById(
            "modalEditar"
        )
        .style.display =
        "none";

}



window.onclick =
    function(event)
    {

        var modal =
            document.getElementById(
                "modalEditar"
            );


        if (
            event.target ==
            modal
        ) {

            cerrarEditar();

        }

    };


</script>



<!-- ======================================================
     GRÁFICO DE INGRESOS
======================================================= -->

<script>


const fechasGrafico =
    <?php
        echo json_encode(
            $fechasGrafico
        );
    ?>;


const montosGrafico =
    <?php
        echo json_encode(
            $montosGrafico
        );
    ?>;


const ctxGrafico =
    document.getElementById(
        "graficoIngresos"
    );


new Chart(

    ctxGrafico,

    {

        type:
            "line",


        data: {

            labels:
                fechasGrafico,


            datasets: [

                {

                    label:
                        "Ingresos en Bs.",

                    data:
                        montosGrafico,

                    borderWidth:
                        3,

                    tension:
                        0.3,

                    fill:
                        true

                }

            ]

        },


        options: {

            responsive:
                true,


            plugins: {

                legend: {

                    display:
                        true,

                    position:
                        "top"

                },


                title: {

                    display:
                        true,

                    text:
                        "Evolución de ingresos"

                }

            },


            scales: {

                y: {

                    beginAtZero:
                        true,

                    title: {

                        display:
                            true,

                        text:
                            "Monto en Bs."

                    }

                },


                x: {

                    title: {

                        display:
                            true,

                        text:
                            "Fecha"

                    }

                }

            }

        }

    }

);


</script>



<!-- ======================================================
     GRÁFICO TOP 3 PRODUCTOS
======================================================= -->

<script>


const productosGrafico =
    <?php
        echo json_encode(
            $productosGrafico
        );
    ?>;


const cantidadesGrafico =
    <?php
        echo json_encode(
            $cantidadesGrafico
        );
    ?>;


const ctxProductos =
    document.getElementById(
        "graficoProductos"
    );


new Chart(

    ctxProductos,

    {

        type:
            "bar",


        data: {

            labels:
                productosGrafico,


            datasets: [

                {

                    label:
                        "Cantidad vendida",

                    data:
                        cantidadesGrafico,

                    borderWidth:
                        1

                }

            ]

        },


        options: {

            responsive:
                true,


            plugins: {

                legend: {

                    display:
                        true,

                    position:
                        "top"

                },


                title: {

                    display:
                        true,

                    text:
                        "Top 3 productos más vendidos"

                }

            },


            scales: {

                y: {

                    beginAtZero:
                        true,

                    ticks: {

                        precision:
                            0

                    },

                    title: {

                        display:
                            true,

                        text:
                            "Cantidad vendida"

                    }

                }

            }

        }

    }

);


</script>


</body>

</html>