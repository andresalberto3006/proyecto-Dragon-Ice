<?php
session_start();
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: iniciosesion.php");
    exit();
}

header("Content-Type: application/json; charset=utf-8");

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$sql = "SELECT * FROM usuario WHERE nombre='$usuario' AND celular='$clave' LIMIT 1";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();

    if ($fila['estado'] == 'Bloqueado') {
        echo json_encode(array(
            "ok"     => false,
            "icono"  => "warning",
            "titulo" => "Usuario bloqueado",
            "texto"  => "Este usuario está bloqueado. Comunícate con el administrador."
        ));
        exit();
    }

    if ($fila['rol'] != 'Administrador' && $fila['rol'] != 'Vendedor') {
        echo json_encode(array(
            "ok"     => false,
            "icono"  => "error",
            "titulo" => "Rol no válido",
            "texto"  => "El rol del usuario no es válido."
        ));
        exit();
    }

    $_SESSION['ci'] = $fila['ci'];
    $_SESSION['usuario'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];

    if ($fila['rol'] == 'Administrador') {
        $destino = "../paginaprincipal/02.admin.php";
    } else {
        $destino = "../paginaprincipal/03.vendedor.php";
    }

    echo json_encode(array(
        "ok"      => true,
        "destino" => $destino
    ));
    exit();
}

echo json_encode(array(
    "ok"     => false,
    "icono"  => "error",
    "titulo" => "Datos incorrectos",
    "texto"  => "Nombre o número de celular incorrectos."
));
?>