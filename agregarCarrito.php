<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$nombreBase = "dragonice";

$conn = new mysqli($servidor, $usuario, $contrasena, $nombreBase);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_productos = $_POST["idproducto"];
$id_pedidos = $_POST["idpedido"];
$cantidad = $_POST["cantidad"];
$costotal = $_POST["costotal"];
$total=$costotal*$cantidad;

$sql = "INSERT INTO carrito
(Producto_codigo,Pedido_id,cantidad,costototal)
VALUES
('$id_productos','$id_pedidos','$cantidad','$total')";

if($conn->query($sql)){
    echo "Producto agregado al carrito";
    header("location: miCarrito.php?idPedido=".$id_pedidos);
}else{
    echo "El producto ya se agregó";
    echo "<a href='fmiCarrito.php?idPedido=$id_pedidos'>
        <button>Volver a Pedidos</button>
      </a>";
}



?>