<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        background-image: url("music-musical-instrument-guitar-two-dark-background.png");
        background-size: cover;
        background-repeat: no-repeat;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: beige;
    }

    #caja {
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        border: 2px solid rgb(241, 241, 241);
        background: #1a1a1a;
        padding: 50px;
        text-align: center;
        width: 325px;
        height: auto;
        animation-name: hola;
        animation-duration: 4s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: infinite;

    }

    label.error {
        color: beige;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    #caja label {
        color: beige;
        font-size: 16px;
        text-align: left;
    }
</style>

<body>
    <form action="regis.php" method="post" id="caja">
        <label for="">Id del Usuario</label>
        <input type="number" name="i"><br>
        <label for="">Nombre Completo:</label>
        <input type="text" name="NombreCompleto"><br>
        <label for="">Fecha De Nacimiento</label>
        <input type="DATE" name="Fechadenacimiento"><br>
        <label for="">Curso</label>
        <input type="number" name="Curso"><br>
        <label for="">Paralelo</label>
        <input type="text" name="Paralelo"><br>
        <label for="">Codigo Rude</label>
        <input type="number" name="CodigoRude"><br>
        <label for="">Carnet De Identidad</label>
        <input type="text" name="Carnetdeidentidad"><br>
        <label for="">Telefono</label>
        <input type="number" name="telefono"><br>
        <label for="">Direccion</label>
        <input type="text" name="direccion"><br>
        <label for="">Rol</label>
        <label for="">Profesor</label><input type="radio" name="rol" value="profesor"><br>
        <label for="">Estudiante</label><input type="radio" name="rol" value="estudiante">
        <br>
        <input type="Submit">
    </form>
</body>

</html>