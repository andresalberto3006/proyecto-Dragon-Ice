<?php
$direccion="localhost";
$usuario="root";
$contrasena="";
$nombreBase="dragonice";

$conexion= new mysqli($direccion,$usuario,$contrasena,$nombreBase);
if($conexion->error){
echo "Hubo un error al conectar a la base de datos";
}

$sql= "SELECT * FROM personas";
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila-$resultado->fetch_assoc()){
echo $fila['Codigo']."<br>".$fila['nombre']."<br>".$fila['descripcion']."<br>".$fila['precio']."<br>"."<br>".$fila['costo']."<br>"."<br>".$fila['stock']."<br>";
$idPersona-$fila['id'];
echo "<a href='persona.php?id=$id'><button >Mostrar</button></a><br>";
}
}
?>