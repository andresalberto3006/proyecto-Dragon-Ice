<?php
include("connection.php");
$con = connection();

$sql = "SELECT * FROM usuario";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/style.css" rel="stylesheet">
    <title>Registro de Producto</title>
</head>

<body>
    <div class="users-form">
        <h1>Crear producto</h1>
        <form action="insert_user.php" method="POST">
            <input type="hidden" name="codigo" value="">
            <input type="hidden" name="id" value="">
            <input type="text" name="name" placeholder="Nombre">
            <input type="text" name="descripcion" placeholder="Descripcion">
            <input type="text" name="precio" placeholder="Precio">
            <input type="text" name="costo" placeholder="costo">
            <input type="stock" name="stock" placeholder="stock">

            <input type="submit" value="Agregar">
        </form>
    </div>

    <div class="users-table">
        <h2>Productos registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Costo</th>
                    <th>Stock</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['id'] ?></th>
                        <th><?= $row['nombre'] ?></th>
                        <th><?= $row['descripcion'] ?></th>
                        <th><?= $row['precio'] ?></th>
                        <th><?= $row['costo'] ?></th>
                        <th><?= $row['stock'] ?></th>
                        <th><a href="updateproductos.php?id=<?= $row['id'] ?>" class="users-table--edit">Editar</a></th>
                        <th><a href="delete.php?id=<?= $row['id'] ?>" class="users-table--delete" >Eliminar</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>