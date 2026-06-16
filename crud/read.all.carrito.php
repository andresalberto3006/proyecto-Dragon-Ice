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
echo $fila['id_productos']."<br>".$fila['id_pedidos']."<br>".$fila['cantidad']."<br>".$fila['costotal']."<br>";
$idPersona-$fila['id'];
echo "<a href=readcarrito.php?id=$idcarrito'><button >Mostrar</button></a><br>";
echo "<a href=updatecarrito.php?id=$idcarrito'><button >Mostrar</button></a><br>";
}
}
?>