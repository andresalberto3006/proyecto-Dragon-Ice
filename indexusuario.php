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
    <title>Registro de Cliente</title>
</head>

<body>
    <div class="users-form">
        <h1>Crear usuario</h1>
        <form action="index.php" method="POST">
            <input type="text" na>
            <input type="hidden" name="ciu" value="">
            <input type="text" name="name" placeholder="Nombre">
            <input type="text" name="direccion" placeholder="Direccion">
            <input type="text" name="celular" placeholder="celular">
            <input type="password" name="rol" placeholder="rol">
            <input type="text" name="estado" placeholder="Estado">

            <input type="submit" value="Agregar">
        </form>
    </div>

    <div class="users-table">
        <h2>Usuarios registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Ciu</th>
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
                        <th><?= $row['ciu'] ?></th>
                        <th><?= $row['nombre'] ?></th>
                        <th><?= $row['descripcion'] ?></th>
                        <th><?= $row['precio'] ?></th>
                        <th><?= $row['costo'] ?></th>
                        <th><?= $row['stock'] ?></th>
                        <th><a href="updateusuario.php?id=<?= $row['id'] ?>" class="users-table--edit">Editar</a></th>
                        <th><a href="delete.php?id=<?= $row['id'] ?>" class="users-table--delete" >Eliminar</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>