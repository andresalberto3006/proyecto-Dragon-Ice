<?php
include("connection.php");
$con = connection();

$ci = $_POST['ci'];;
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$sql = "INSERT INTO users VALUES('$ci','$nombre','$direccion','$celular','$rol','$estado')";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: index.php");
}else{

}

?>
<?php header("Location: usuario/formulariousuario.php"); exit(); ?>