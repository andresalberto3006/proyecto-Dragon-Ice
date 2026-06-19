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
echo $fila['ci']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado']."<br>";
$idPersona-$fila['ci'];
echo "<a href=readusuario.php?id=$idusuario'><button >Mostrar</button></a><br>";
echo "<a href=updateusuario.php?id=$idusuario'><button >Mostrar</button></a><br>";
}
}
?>