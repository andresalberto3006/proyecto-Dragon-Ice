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
echo $fila['id']."<br>".$fila['nombre']."<br>".$fila['fecha']."<br>".$fila['estado']."<br>".$fila['nombrevendedor']."<br>";
$idPersona-$fila['id'];
echo "<a href=readpedidos.php?id=$idpedidos'><button >Mostrar</button></a><br>";
echo "<a href=updatepedidos.php?id=$idpedidos'><button >Mostrar</button></a><br>";
}
}
?>
<?php header("Location: ../pedidos.php"); exit(); ?>