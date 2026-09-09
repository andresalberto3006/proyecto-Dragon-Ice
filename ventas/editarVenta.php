<?php
session_start();

if(!isset($_SESSION['rol'])){
    header("Location: ../iniciosesion.php");
    exit();
}

if($_SESSION['rol'] !== 'Administrador'){
    header("Location: ../paginaprincipal/vendedor20.php");
    exit();
}

include("../conexion.php");

$id = (int)($_GET['id'] ?? 0);

if($id <= 0){
    header("Location: ventas.php");
    exit();
}

$mensaje = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $cliente = trim($_POST['cliente'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');
    $vendedorCi = (int)($_POST['vendedor_ci'] ?? 0);
    $total = (float)($_POST['total'] ?? 0);
    $metodoPago = trim($_POST['metodo_pago'] ?? '');

    if($cliente === '' || $fecha === '' || $vendedorCi <= 0 || $metodoPago === ''){
        $mensaje = 'Completa todos los campos.';
    } else {

        $sv = $conexion->prepare("SELECT nombre FROM usuario WHERE ci=? LIMIT 1");
        $sv->bind_param('i', $vendedorCi);
        $sv->execute();
        $vendedor = $sv->get_result()->fetch_assoc();

        if(!$vendedor){
            $mensaje = 'Vendedor no válido.';
        } else {

            $nombreVendedor = $vendedor['nombre'];

            $s = $conexion->prepare("UPDATE ventas SET cliente=?, fecha=?, vendedor_ci=?, nombrevendedor=?, total=?, metodo_pago=? WHERE id=?");
            $s->bind_param('ssisdsi', $cliente, $fecha, $vendedorCi, $nombreVendedor, $total, $metodoPago, $id);

            if($s->execute()){
                header("Location: ventas.php");
                exit();
            } else {
                $mensaje = 'Error al actualizar la venta: ' . $s->error;
            }
        }
    }
}

$s = $conexion->prepare("SELECT * FROM ventas WHERE id=? LIMIT 1");
$s->bind_param('i', $id);
$s->execute();
$venta = $s->get_result()->fetch_assoc();

if(!$venta){
    header("Location: ventas.php");
    exit();
}

$vendedores = $conexion->query("SELECT ci, nombre FROM usuario WHERE rol='Vendedor' ORDER BY nombre");

$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Venta</title>
<style>

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
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:40px;
    display:flex;
    justify-content:center;
    align-items:flex-start;
}

.contenedor{
    width:100%;
    max-width:600px;
    background:white;
    padding:30px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

h1{
    text-align:center;
    color:#18335c;
    margin-bottom:30px;
}

label{
    display:block;
    margin-bottom:6px;
    color:#18335c;
    font-weight:bold;
}

input, select{
    width:100%;
    padding:12px;
    margin-bottom:18px;
    border:1px solid #c9e5ee;
    border-radius:9px;
    outline:none;
}

input:focus, select:focus{
    border-color:#4da6ff;
}

.mensaje{
    background:#fdecea;
    color:#a12622;
    padding:12px;
    border-radius:10px;
    margin-bottom:18px;
    text-align:center;
}

.botones{
    display:flex;
    gap:10px;
}

button, .cancelar{
    flex:1;
    padding:13px;
    border:0;
    border-radius:9px;
    font-weight:bold;
    cursor:pointer;
    text-align:center;
    text-decoration:none;
}

button{
    background:#18335c;
    color:white;
}

button:hover{
    background:#2f5d9f;
}

.cancelar{
    background:#eaf7fb;
    color:#18335c;
}

.cancelar:hover{
    background:#d6edf5;
}

</style>
</head>
<body>
    <?php include("../menu.php"); ?>

    <main class="fondo-panel">
        <div class="contenedor">

            <h1>Editar Venta #<?php echo $venta['id']; ?></h1>

            <?php if($mensaje !== ''){ ?>
                <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php } ?>

            <form method="POST">

                <label>Cliente</label>
                <input type="text" name="cliente" value="<?php echo htmlspecialchars($venta['cliente']); ?>" required>

                <label>Fecha</label>
                <input type="date" name="fecha" value="<?php echo htmlspecialchars($venta['fecha']); ?>" required>

                <label>Vendedor</label>
                <select name="vendedor_ci" required>
                    <?php while($v = $vendedores->fetch_assoc()){ ?>
                        <option value="<?php echo $v['ci']; ?>" <?php echo ($v['ci'] == $venta['vendedor_ci']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($v['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Total (Bs.)</label>
                <input type="number" step="0.01" name="total" value="<?php echo $venta['total']; ?>" required>

                <label>Método de pago</label>
                <select name="metodo_pago" required>
                    <option value="QR" <?php echo ($venta['metodo_pago']=='QR') ? 'selected' : ''; ?>>Pago mediante QR</option>
                    <option value="Efectivo" <?php echo ($venta['metodo_pago']=='Efectivo') ? 'selected' : ''; ?>>Pago en efectivo</option>
                </select>

                <div class="botones">
                    <button type="submit">Guardar cambios</button>
                    <a href="ventas.php" class="cancelar">Cancelar</a>
                </div>

            </form>

        </div>
    </main>

    <?php include("../paginaprincipal/piedepagina.php"); ?>
</body>
</html>