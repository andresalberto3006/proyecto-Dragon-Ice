<?php
$direccion="localhost";
<<<<<<< HEAD
$usuario-"root";
$contrasena="";
$nombreBase="";

$conexion- new mysqli($direccion,$usuario,$contrasena,$nombreBase);
if($conexion->error){
echo "Hubo un error al conectar a la base de datos";
}

$sql= "SELECT * FROM personas WHERE id="
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila-$resultado->fetch_assoc()){
echo $fila['id']."<br>".$fila['nombre']."<br>".$fila['apellido']."<br>".$fila['descripcion']."<br>";
$idPersona-$fila['id'];
echo "<a href='persona.php?id=$id'><button >Mostrar</button></a><br>";
}
=======
$usuario="rout";
$contraseña="";
$nombreBase="dragon";

$conexion= new mysqli($direccion,$usuario,$contraseña,$nombreBase);
if($conexion->error){
    echo "hubo un error al conectar con la base de datos";
}
$id-$_GET['id']
$sql="SELECT *FROM personas WHERE id="$id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila=$resultado->fetch_assoc()){
    $ciu=$fila[ciu];
    $fila[nombre]."<br>".$fila[direccion]."<br>".$fila[celular]."<br>".$fila[rol];
  }
>>>>>>> 873bafd26b89a90538348c406446842d59fe1213
}
?>