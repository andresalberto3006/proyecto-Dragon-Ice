<?php
$ciu= "localhost";
$nombre= "root";
$direccion= "root";
$celular= "root";
$rol= "root";
$estado= "root";
$nombrebase= "dragon";
$conexion= new mysqli($ciu,$nombre,$direccion,$celular,$rol,$estado,$nombrebase);
if($conexion->error) {
    echo" Hubo un error al conectar a la base de datos";
}
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$celular=$_POST['celular'];
$rol=$_POST['rol'];
$estado=$_POST['estado'];
$sql ="INSERT INTO personas(nombre,direccion, elular,rol,estado) VALUES ('$nombre', '$direccion', '$celular', '$rol', '$estado')";
if($conexion->query($sql)===TRUE){
    echo "
    <style>
body{
    background: linear-gradient(to right, #00c6ff, #0072ff);
    font-family: Arial, sans-serif;
}

.mensaje{
    width: 500px;
    margin: 100px auto;
    background: white;
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0px 0px 20px rgba(0,0,0,0.3);
}

.mensaje h1{
    color: #0099ff;
    font-size: 40px;
}

.mensaje p{
    color: #333;
    font-size: 20px;
}

.mensaje .ice{
    font-size: 60px;
}
</style>

<div class='mensaje'>
    <div class='ice'>🍦❄️</div>
    <h1>¡Perfecto!</h1>
    <p>Ya te pudiste registrar correctamente en <b>Dragon Ice</b></p>
</div>
";

}
else{
    echo $sql->error;
}

?>
