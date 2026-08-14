<?php
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'Vendedor')) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Sesión inválida."
    ]);
    exit();
}

include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Método no permitido."
    ]);
    exit();
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
$precio = isset($_POST['precio']) ? $_POST['precio'] : '';
$costo = isset($_POST['costo']) ? $_POST['costo'] : '';
$stock = isset($_POST['stock']) ? $_POST['stock'] : '';

if ($id <= 0 || $nombre === '' || $descripcion === '' || $precio === '' || $costo === '' || $stock === '') {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Complete todos los campos obligatorios."
    ]);
    exit();
}

$imagen = "imagenesproyecto/helado.jpg";

if (isset($_FILES['imagen']) && $_FILES['imagen']['name'] != "") {
    $nombreImagen = time()."_".$_FILES['imagen']['name'];
    $destino = "../imagenesproyecto/".$nombreImagen;
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
        $imagen = "imagenesproyecto/".$nombreImagen;
    }
}

$stmt = $conexion->prepare("
    INSERT INTO productos(id, nombre, descripcion, precio, costo, stock, imagen)
    VALUES(?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issddis",
    $id,
    $nombre,
    $descripcion,
    $precio,
    $costo,
    $stock,
    $imagen
);

if ($stmt->execute()) {

    echo json_encode([
        "ok" => true,
        "mensaje" => "Producto registrado correctamente.",
        "id" => $id
    ]);

} else {

    if ($conexion->errno == 1062) {
        $mensajeError = "Ese código de producto ya está registrado.";
    } else {
        $mensajeError = "No se pudo registrar el producto.";
    }

    echo json_encode([
        "ok" => false,
        "mensaje" => $mensajeError
    ]);
}

exit();
?>