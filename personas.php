<?php
$direccion="localhost";
$usuario-"root";
$contrasena="";
$nombreBase="produccion";

$conexion- new mysqli($nombre,$apellido,$descripcion,$produccion);
if($conexion->error){
echo "Hubo un error al conectar a la base de datos";
}

$sql= "SELECT * FROM personas";
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila-$resultado->fetch_assoc()){
echo $fila['id']."<br>".$fila['nombre']."<br>".$fila['apellido']."<br>".$fila['descripcion']."<br>";
$idPersona-$fila['id'];
echo "<a href='persona.php?id=$id'><button >Mostrar</button></a><br>";
}
}
?>