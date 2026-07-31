<?php
session_start();

$conexion = mysqli_connect("localhost", "root", "", "dragonice");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: iniciosesion.php");
    exit();
}

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$sql = "SELECT * FROM usuariosesion
        WHERE usuario='$usuario'
        AND clave='$clave'
        LIMIT 1";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado) > 0) {

    $fila = mysqli_fetch_assoc($resultado);

    $_SESSION['id'] = $fila['id'];
    $_SESSION['usuario'] = $fila['usuario'];
    $_SESSION['clave'] = $fila['clave'];
    $_SESSION['apellido'] = $fila['apellido'];
    $_SESSION['rol'] = $fila['rol'];

    if ($fila['rol'] == 1) {
        header("Location: 03.usuario.php");
        exit();
    } elseif ($fila['rol'] == 2) {
        header("Location: 02.admin.php");
        exit();
    } elseif ($fila['rol'] == 3) {
        header("Location: 04.vendedor.php");
        exit();
    } else {
        echo "Rol no válido";
    }

} else {
    echo "Usuario o número de celular incorrectos";
}
?>