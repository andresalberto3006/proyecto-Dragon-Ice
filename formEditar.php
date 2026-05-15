<?php
$direccion="localhost";
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
}
?>