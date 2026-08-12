<?php
include("../../conexion.php");
$idUser = $_GET['ci'];

$sql = "UPDATE cuenta SET rol='vendedor' WHERE ci='$idUser'";
if (mysqli_query($conn, $sql)){
    header("Location: read_all.usuarios.php?ci=$idUser");
} else{
    echo "Error al actualizar el rol: " . mysqli_error($conn);
}
