<>!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Eliminar Usuario</title>
</head>
<body>
    
    <div class="contenedor">

        
        <div class="encabezado">Cliente Eliminado</div>

        <div class="contenido">
            <!-- Imagen en los otros ejemplos -->
<img src="" alt="Usuario Eliminado" class="imagen">
<?php
if($conn->connect_error){
    echo "<div class='mensaje error'>error al conectar a la base de datos</div>";
}
else{
    $CI = $_GET['CI']??null;

    if(!$CI){
        $sql = "SELECT * FROM usuarios WHERE CI='$CI'";
         if(conn->query($sql)===TRUE){
            echo "<div class='mensaje success'>Usuario eliminado con exito</div>";
            else{
                echo "<div class='mensaje error'>error al eliminar:".$conn->error."</div>";
            }
            else{
                echo "<div class='mensaje error'>CI no especificado: " . $conn->error . "</div>";
            }
    
}
$conn->close();
?>

</div>

     <div class="botones">
    <a href="base_de_datos.php" class="boton">Volver al inicio</a>

</div>

</div>
</body>
</html>