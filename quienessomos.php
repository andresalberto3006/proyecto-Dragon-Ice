<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quiénes somos | Dragon Ice</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter', Arial, sans-serif;
}

h1,h2{
    font-family:'Baloo 2', Arial, sans-serif;
}

/* HERO */

.hero{
    position:relative;
    height:100vh;
    display:flex;
    align-items:center;
}

.hero img{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
    z-index:-1;
}

.hero::after{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(5,11,22,0.45);
    z-index:-1;
}

.hero-texto{
    width:100%;
    padding:30px;
    text-align:center;
    color:white;
}

.hero-texto h1{
    font-size:58px;
    letter-spacing:4px;
}

.hero-texto p{
    margin-top:14px;
    font-size:18px;
    max-width:600px;
    margin-inline:auto;
}

/* SECCIONES */

.seccion{
    max-width:1100px;
    margin:90px auto;
    padding:0 30px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:50px;
    align-items:center;
}

.seccion.invertida .imagen{
    order:-1;
}

.seccion .chip{
    font-size:13px;
    font-weight:700;
    letter-spacing:2px;
    text-transform:uppercase;
    color:#29a8e0;
    margin-bottom:12px;
}

.seccion h2{
    font-size:34px;
    color:#0e2a4d;
    margin-bottom:16px;
}

.seccion p{
    font-size:16px;
    line-height:1.8;
    color:#4b5563;
}

.seccion img{
    width:100%;
    height:380px;
    object-fit:cover;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

/* CTA */

.cta{
    text-align:center;
    padding:90px 30px;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
}

.cta h2{
    color:white;
    font-size:32px;
    margin-bottom:14px;
}

.cta p{
    color:#e6f3ff;
    margin-bottom:25px;
}

.cta a{
    display:inline-block;
    background:white;
    color:#18335c;
    text-decoration:none;
    font-weight:700;
    padding:14px 36px;
    border-radius:30px;
}

@media(max-width:900px){
    .hero-texto h1{ font-size:38px; }
    .seccion{ grid-template-columns:1fr; margin:60px auto; }
    .seccion.invertida .imagen{ order:0; }
}

</style>
</head>
<body>

<?php $rutaMenu=""; include("menu.php"); ?>

<section class="hero">
    <img src="https://images.unsplash.com/photo-1580915411954-282cb1b0d780?auto=format&fit=crop&w=1800&q=80" alt="Helados Dragon Ice">
    <div class="hero-texto">
        <h1>DRAGON ICE</h1>
        <p>Helados artesanales hechos con ingredientes reales, mucho cariño y ganas de alegrar tu día.</p>
    </div>
</section>

<section class="seccion">
    <div>
        <div class="chip">Nuestra historia</div>
        <h2>Helado hecho como debe ser</h2>
        <p>Dragon Ice es una empresa dedicada a la elaboración y comercialización de helados artesanales de excelente calidad. Nació con una idea simple: usar ingredientes de verdad y recetas propias para ofrecer un helado distinto en cada cucharada.</p>
    </div>
    <div class="imagen">
        <img src="https://images.unsplash.com/photo-1562790879-dfde82829db0?auto=format&fit=crop&w=1200&q=80" alt="Helado de chocolate">
    </div>
</section>

<section class="seccion invertida">
    <div>
        <div class="chip">Misión</div>
        <h2>Calidad en cada sabor</h2>
        <p>Elaborar y comercializar helados artesanales de alta calidad, brindando productos frescos, deliciosos e innovadores, junto a una atención eficiente y un compromiso constante con la satisfacción de nuestros clientes.</p>
    </div>
    <div class="imagen">
        <img src="https://images.unsplash.com/photo-1497034825429-c343d7c6a68f?auto=format&fit=crop&w=1200&q=80" alt="Helado de fresa">
    </div>
</section>

<section class="seccion">
    <div>
        <div class="chip">Visión</div>
        <h2>Un referente artesanal</h2>
        <p>Ser una empresa líder y reconocida en el mercado de helados artesanales, destacándonos por la calidad de nuestros productos, la innovación permanente y la preferencia de nuestros clientes.</p>
    </div>
    <div class="imagen">
        <img src="https://images.unsplash.com/photo-1567206563064-6f60f40a2b57?auto=format&fit=crop&w=1200&q=80" alt="Variedad de helados">
    </div>
</section>

<section class="cta">
    <h2>¿Listo para probarlo?</h2>
    <p>Descubre todo nuestro catálogo de helados artesanales.</p>
    <a href="paginaprincipal/productos.php">Ver productos</a>
</section>

<?php include("paginaprincipal/piedepagina.php"); ?>

</body>
</html>