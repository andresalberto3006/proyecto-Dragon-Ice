<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Heladería</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #cfe9ff, #e8f4ff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .formulario{
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 35px;
            border-radius: 20px;<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nuestros Sabores</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f9f9f9;
      text-align: center;
    }

    h1 {
      background-color: #4a90e2;
      color: white;
      padding: 15px;
      margin: 0;
    }

    .contenedor {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
      padding: 20px;
    }

    .card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      width: 250px;
      overflow: hidden;
    }

    .card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-bottom: 3px solid #4a90e2;
    }

    .card p {
      padding: 10px;
      font-size: 0.9rem;
    }

    footer {
      background-color: #4a90e2;
      color: white;
      padding: 10px;
      margin-top: 20px;
    }
    
  </style>
</head>
<body>
  <h1>🍦 Nuestros sabores que te refrescarán en los días de calor</h1>

  <div class="contenedor">
    <div class="card">
      <img src="durazno.jpg" alt="Durazno">
      <p>🍑 El helado de durazno es refrescante y dulce, ideal para días calurosos.</p>
    </div>

    <div class="card">
      <img src="frutilla.jpg" alt="Frutilla">
      <p>🍓 El helado de frutilla es dulce, refrescante y con un color rosa vibrante que encanta a todos.</p>
    </div>

    <div class="card">
      <img src="canela.jpg" alt="Canela">
      <p>🌿 El helado de canela tiene un sabor cálido, aromático y ligeramente especiado que combina muy bien con frutas, chocolate o nueces.</p>
    </div>

    <div class="card">
      <img src="leche.jpg" alt="Leche">
      <p>🥛 El helado de leche es cremoso, suave y muy clásico.</p>
    </div>

    <div class="card">
      <img src="cafe.jpg" alt="Café">
      <p>☕ El helado de café es cremoso y con un sabor intenso que encanta a los amantes del café.</p>
    </div>

    <div class="card">
      <img src="platano.jpg" alt="Plátano">
      <p>🍌 Un helado de plátano es delicioso, cremoso y naturalmente dulce.</p>
    </div>
  </div>

  <footer>© 2025 Sabores Refrescantes</footer>
</body>
</html>

            box-shadow: 0px 10px 25px rgba(0,0,0,0.12);
        }

        .formulario h2{
            text-align: center;
            color: #3498db;
            margin-bottom: 25px;
            font-size: 30px;
        }

        .grupo{
            margin-bottom: 18px;
        }

        label{
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
        }

        input{
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cfd9e2;
            border-radius: 12px;
            font-size: 15px;
            transition: 0.3s;
            background-color: #f8fbff;
        }

        input:focus{
            border-color: #5dade2;
            box-shadow: 0px 0px 8px rgba(93, 173, 226, 0.4);
            outline: none;
            background-color: white;
        }

        .boton{
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #5dade2, #3498db);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .boton:hover{
            background: linear-gradient(135deg, #3498db, #2e86c1);
            transform: translateY(-2px);
            box-shadow: 0px 5px 12px rgba(52, 152, 219, 0.4);
        }

        .subtitulo{
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 25px;
            font-size: 14px;
        }

    </style>
</head>

<body>

    <div class="formulario">

        <h2>🍦 Registrar Producto</h2>
        <p class="subtitulo">
            Complete los datos del producto de la heladería
        </p>

        <form action="registro.php" method="POST">

            <div class="grupo">
                <label for="ci">Código / CI</label>
                <input type="text" id="ci" name="ci" placeholder="Ingrese el código">
            </div>

            <div class="grupo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre">
            </div>

            <div class="grupo">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" placeholder="Descripción del producto">
            </div>

            <div class="grupo">
                <label for="precio">Precio</label>
                <input type="text" id="precio" name="precio" placeholder="Ingrese el precio">
            </div>

            <div class="grupo">
                <label for="costo">Costo</label>
                <input type="text" id="costo" name="costo" placeholder="Ingrese el costo">
            </div>

            <div class="grupo">
                <label for="stock">Stock</label>
                <input type="text" id="stock" name="stock" placeholder="Cantidad disponible">
            </div>

            <button type="submit" class="boton">
                Guardar Producto
            </button>

        </form>

    </div>

</body>
</html>