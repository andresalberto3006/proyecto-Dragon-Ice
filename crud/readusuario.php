<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Hubo un error al conectar a la base de datos");
}

$ci = $_GET['ci'];

$sql = "SELECT * FROM usuario WHERE ci='$ci'";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuario Registrado</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
}

.tarjeta{

    width:650px;

    background:white;

    padding:40px;

    border-radius:25px;

    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

h1{
    text-align:center;
    color:#18335c;
    margin-bottom:30px;
}

.dato{
    background:#f4f8ff;

    padding:15px;

    margin-bottom:15px;

    border-left:6px solid #4da6ff;

    border-radius:10px;

    font-size:18px;
}

strong{
    color:#18335c;
}

.botones{
    margin-top:30px;
    display:flex;
    justify-content:center;
    gap:15px;
}

.boton{

    text-decoration:none;

    background:#4da6ff;

    color:white;

    padding:12px 25px;

    border-radius:10px;

    font-weight:bold;

    transition:.3s;
}

.boton:hover{
    background:#2f5d9f;
}

</style>

</head>

<body>

<div class="tarjeta">

<h1>🍦 Información del Usuario</h1>

<?php

if($resultado->num_rows > 0){

    $fila = $resultado->fetch_assoc();

?>

<div class="dato">
    <strong>CI:</strong>
    <?php echo $fila['ci']; ?>
</div>

<div class="dato">
    <strong>Nombre:</strong>
    <?php echo $fila['nombre']; ?>
</div>

<div class="dato">
    <strong>Dirección:</strong>
    <?php echo $fila['direccion']; ?>
</div>

<div class="dato">
    <strong>Celular:</strong>
    <?php echo $fila['celular']; ?>
</div>

<div class="dato">
    <strong>Rol:</strong>
    <?php echo $fila['rol']; ?>
</div>

<div class="dato">
    <strong>Estado:</strong>
    <?php echo $fila['estado']; ?>
</div>

<?php

}else{

    echo "<div class='dato'>Usuario no encontrado.</div>";

}

?>

<div class="botones">

    <a href="read.all.usuario.php" class="boton">
        Ver todos los usuarios
    </a>

    <a href="../formularios/05.formulariousuario.php" class="boton">
        Registrar Usuario
    </a>

</div>

</div>

</body>
</html>