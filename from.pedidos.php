<?php
    session_start();
    $vendedor=$_SESSION['Nombre'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Pedido</title>
</head>
<body>

<h2>Generar Pedido</h2>

<form action="07.formulariopedido.php" method="POST">

    id:
    <input type="number" name="id"><br><br>

    Nombre:
    <input type="text" name="nombre"><br><br>

    Fecha:
    <input type="date" name="fecha" ><br><br>

    Estado:
    <input type="text" name="estado">

    Nombre Vendedor:
    <input type="text" name="nombreVendedor"><br><br>

    <input type="submit" value="Nuevo Pedido">

</form>

</body>
</html>