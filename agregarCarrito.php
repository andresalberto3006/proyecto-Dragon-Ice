<?php

$conexion = mysqli_connect("localhost","root","","dragonice");

if(!$conexion){
    die("Error de conexión");
}

$idProducto = $_POST["idProducto"];
$idPedido   = $_POST["idPedido"];
$cantidad   = $_POST["cantidad"];
$precio     = $_POST["precio"];

$total = $cantidad * $precio;

/* Verificar si el producto ya está en el carrito */

$sqlVerificar = "SELECT *
                 FROM carrito
                 WHERE productos_id='$idProducto'
                 AND pedidos_id='$idPedido'";

$resultado = mysqli_query($conexion,$sqlVerificar);

if(mysqli_num_rows($resultado)>0){

    echo "<script>
            alert('Este producto ya fue agregado al carrito');
            window.location='miCarrito.php?idPedido=$idPedido';
          </script>";

}else{

    $sql = "INSERT INTO carrito
            (productos_id,pedidos_id,cantidad,costototal)
            VALUES
            ('$idProducto',
             '$idPedido',
             '$cantidad',
             '$total')";

    if(mysqli_query($conexion,$sql)){

        header("Location: miCarrito.php?idPedido=".$idPedido);

    }else{

        echo "Error: ".mysqli_error($conexion);

    }

}

?>