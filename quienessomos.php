

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dragon Ice</title>

<style>

body{
    background:linear-gradient(to bottom,#d8e8ff,#f4f8ff);
}

.contenedor{
    max-width:1200px;
    margin:auto;
    padding:50px 30px;
}

.presentacion{
    text-align:center;
    padding:80px 40px;
    margin-top:40px;
    border-radius:30px;
    background:rgba(255,255,255,0.85);
    box-shadow:0 5px 20px rgba(0,0,0,0.15);
}

.presentacion h1{
    font-size:80px;
    color:#2d4f7c;
    letter-spacing:8px;
    margin-bottom:25px;
    text-shadow:2px 2px 10px rgba(0,0,0,0.2);
}

.presentacion p{
    font-size:24px;
    color:#444;
    line-height:1.8;
    max-width:900px;
    margin:auto;
}

.informacion{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:30px;
    margin-top:50px;
}

.tarjeta{
    background:white;
    padding:35px;
    border-radius:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.12);
    transition:0.3s;
}

.tarjeta:hover{
    transform:translateY(-5px);
}

.tarjeta h2{
    color:#2d4f7c;
    font-size:32px;
    margin-bottom:20px;
}

.tarjeta p{
    font-size:20px;
    color:#555;
    line-height:1.8;
    text-align:justify;
}

@media(max-width:768px){

    .presentacion h1{
        font-size:50px;
        letter-spacing:4px;
    }

    .presentacion p{
        font-size:18px;
    }

    .tarjeta h2{
        font-size:26px;
    }

    .tarjeta p{
        font-size:18px;
    }
}

</style>

</head>

<body>

<header class="menu-principal">

  <?php
  include("menu.php")
  
  ?>

</header>

<div class="contenedor">

```
<section class="presentacion">

    <h1>DRAGON ICE</h1>

    <p>
        Bienvenido a Dragon Ice, una empresa dedicada a la elaboración
        y comercialización de helados artesanales de excelente calidad.
        Nuestro objetivo es brindar productos únicos, deliciosos y
        refrescantes que permitan a nuestros clientes disfrutar
        experiencias inolvidables en cada visita.
    </p>

</section>

<section class="informacion">

    <div class="tarjeta">

        <h2>📖 Descripción</h2>

        <p>
            Dragon Ice es una empresa especializada en la producción y
            venta de helados artesanales elaborados con ingredientes de
            calidad. Nos caracterizamos por ofrecer sabores innovadores,
            una atención cordial y productos que combinan creatividad,
            frescura y excelencia para satisfacer los gustos de nuestros
            clientes.
        </p>

    </div>

    <div class="tarjeta">

        <h2>🎯 Misión</h2>

        <p>
            Elaborar y comercializar helados artesanales de alta calidad,
            brindando a nuestros clientes productos frescos, deliciosos e
            innovadores, acompañados de una atención eficiente y un
            compromiso constante con la satisfacción de quienes confían
            en nuestra empresa.
        </p>

    </div>

    <div class="tarjeta">

        <h2>🚀 Visión</h2>

        <p>
            Ser una empresa líder y reconocida en el mercado de helados
            artesanales, destacándonos por la calidad de nuestros
            productos, la innovación permanente y la preferencia de los
            clientes, consolidándonos como una marca referente en el
            sector gastronómico.
        </p>

    </div>

</section>


</div>

<?php
include("piedepagina.php");
?>

</body>
</html>
