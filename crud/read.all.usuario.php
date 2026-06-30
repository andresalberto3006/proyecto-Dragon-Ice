<?php

$direccion="localhost";
$usuario="root";
$contraseña="";
$nombreBase="dragonice";

$conn = new mysqli($direccion,$usuario,$contraseña,$nombreBase);

if($conn->connect_error){
    die("Hubo un error al conectar a la base de datos");
}

$sql = "SELECT * FROM usuario";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Todos los Usuarios</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:40px;
}

.contenedor{

    max-width:1200px;
    margin:auto;

    background:white;

    padding:30px;

    border-radius:25px;

    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

h1{
    text-align:center;
    color:#18335c;
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
}

th{
    background:#4da6ff;
    color:white;
    padding:15px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f4f8ff;
}

.boton{

    text-decoration:none;

    color:white;

    padding:8px 15px;

    border-radius:8px;

    font-size:14px;

    font-weight:bold;
}

.mostrar{
    background:#4da6ff;
}

.editar{
    background:#28a745;
}

.eliminar{
    background:#dc3545;
}

.acciones{
    display:flex;
    justify-content:center;
    gap:8px;
}

.volver{
    display:block;
    width:250px;
    margin:30px auto 0;
    text-align:center;
    text-decoration:none;
    background:#18335c;
    color:white;
    padding:15px;
    border-radius:10px;
    font-weight:bold;
}

.volver:hover{
    background:#2f5d9f;
}

</style>

</head>

<body>

<div class="contenedor">

    <h1>🍦 Lista de Usuarios Registrados</h1>

    <table>

        <tr>
            <th>CI</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Celular</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php

        if($resultado->num_rows > 0){

            while($fila = $resultado->fetch_assoc()){

                echo "<tr>";

                echo "<td>".$fila['ci']."</td>";
                echo "<td>".$fila['nombre']."</td>";
                echo "<td>".$fila['direccion']."</td>";
                echo "<td>".$fila['celular']."</td>";
                echo "<td>".$fila['rol']."</td>";
                echo "<td>".$fila['estado']."</td>";

                echo "<td>
                        <div class='acciones'>

                        <a class='boton mostrar' href='readusuario.php?ci=".$fila['ci']."'>
                        Mostrar
                        </a>

                        <a class='boton editar' href='updateusuario.php?ci=".$fila['ci']."'>
                        Editar
                        </a>

                        <a class='boton eliminar' href='delete_usuario.php?ci=".$fila['ci']."'>
                        Eliminar
                        </a>

                        </div>
                      </td>";

                echo "</tr>";
            }

        }else{

            echo "<tr>";
            echo "<td colspan='7'>No existen usuarios registrados.</td>";
            echo "</tr>";

        }

        ?>

    </table>

    <a href="../formularios/05.formulariousuario.php" class="volver">
        ➕ Registrar Nuevo Usuario
    </a>

</div>

</body>
</html>