<?php
$direccion="localhost";
$usuario="root";
$contrasena="";
$nombreBase="dragonice";

$conexion= new mysqli($nombre,$direccion,$celular,$rol,$estado);
if($conexion->error){
echo "Hubo un error al conectar a la base de datos";
}

$sql= "SELECT * FROM personas";
$resultado = $conexion->query($sql);
if ($resultado->num_rows>0){
while($fila-$resultado->fetch_assoc()){
echo $fila['ciu']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado']."<br>";
$idPersona-$fila['ciu'];
echo "<a href='persona.php?id=$id'><button >Mostrar</button></a><br>";
}
}
?>