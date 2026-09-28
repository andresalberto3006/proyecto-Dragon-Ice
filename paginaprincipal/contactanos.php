<?php
session_start();
$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contáctanos | Dragon Ice</title>

<style>

:root{
    --azul-oscuro:#0e2a4d;
    --celeste:#29a8e0;
    --celeste-claro:#63d4f2;
    --menta:#7be0c4;
    --gris-texto:#5b7590;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter', Arial, sans-serif;
}

h1,h2,h3{
    font-family:'Baloo 2', Arial, sans-serif;
}

body{
    background:#ffffff;
    color:var(--azul-oscuro);
}


.hero{
    position:relative;
    height:380px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.hero video{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:100%;
    height:100%;
    object-fit:cover;
}

.hero::after{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(14,42,77,0.6);
}

.hero-texto{
    position:relative;
    z-index:2;
    text-align:center;
    color:white;
    padding:0 20px;
}

.hero-texto h1{
    font-size:60px;
    letter-spacing:6px;
    text-shadow:0 0 15px rgba(0,0,0,0.6);
}

.hero-texto p{
    margin-top:12px;
    font-size:18px;
    color:#e6f3ff;
}


.contenedor{
    max-width:1150px;
    margin:0 auto;
    padding:70px 24px 40px;
}

.encabezado{
    text-align:center;
    max-width:600px;
    margin:0 auto 45px;
}

.chip{
    display:inline-block;
    font-size:13px;
    font-weight:700;
    letter-spacing:2px;
    text-transform:uppercase;
    color:var(--celeste);
    margin-bottom:10px;
}

.encabezado h2{
    font-size:36px;
    color:var(--azul-oscuro);
}


.datos{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:24px;
}

.dato{
    background:white;
    border:1px solid #e2edf5;
    border-radius:18px;
    padding:34px 22px;
    text-align:center;
    box-shadow:0 6px 20px rgba(14,42,77,.08);
    transition:transform .3s, box-shadow .3s;
}

.dato:hover{
    transform:translateY(-6px);
    box-shadow:0 14px 30px rgba(14,42,77,.16);
}

.dato .icono{
    width:60px;
    height:60px;
    margin:0 auto 18px;
    border-radius:50%;
    background:#eaf8fc;
    color:#159db9;
    display:flex;
    align-items:center;
    justify-content:center;
}

.dato .icono svg{
    width:28px;
    height:28px;
    stroke:currentColor;
    fill:none;
    stroke-width:1.8;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.dato h3{
    font-size:19px;
    margin-bottom:8px;
}

.dato p,
.dato a{
    font-size:15px;
    line-height:1.6;
    color:var(--gris-texto);
    text-decoration:none;
    word-break:break-word;
}

.dato a:hover{
    color:var(--celeste);
}


.ubicacion{
    display:grid;
    grid-template-columns:1fr 1.2fr;
    gap:40px;
    align-items:stretch;
    margin-top:70px;
}

.ubicacion .imagen img{
    width:100%;
    height:100%;
    min-height:340px;
    object-fit:cover;
    border-radius:22px;
    box-shadow:0 20px 45px rgba(0,0,0,0.2);
}

.ubicacion .mapa iframe{
    width:100%;
    height:100%;
    min-height:340px;
    border:0;
    border-radius:22px;
    box-shadow:0 20px 45px rgba(0,0,0,0.2);
}


.redes-bloque{
    text-align:center;
    margin-top:70px;
}

.redes-bloque h2{
    font-size:30px;
    margin-bottom:8px;
}

.redes-bloque p{
    color:var(--gris-texto);
    margin-bottom:24px;
}

.redes{
    display:flex;
    justify-content:center;
    gap:16px;
}

.redes a{
    width:52px;
    height:52px;
    border-radius:50%;
    background:var(--azul-oscuro);
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.25s;
}

.redes a:hover{
    background:var(--celeste-claro);
    transform:translateY(-3px);
}

.redes svg{
    width:22px;
    height:22px;
    fill:white;
}

.redes a:hover svg{
    fill:var(--azul-oscuro);
}


.cta{
    text-align:center;
    padding:80px 30px;
    margin-top:60px;
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
    margin:5px;
    transition:.25s;
}

.cta a:hover{
    background:var(--menta);
}


@media(max-width:1000px){
    .datos{ grid-template-columns:1fr 1fr; }
}

@media(max-width:800px){
    .ubicacion{ grid-template-columns:1fr; }
    .hero-texto h1{ font-size:38px; letter-spacing:3px; }
    .encabezado h2{ font-size:28px; }
}

@media(max-width:520px){
    .datos{ grid-template-columns:1fr; }
}

</style>
</head>
<body>

<?php include("menu.php"); ?>

<section class="hero">
    <video autoplay muted loop>
        <source src="../imagenesproyecto/helado1.mp4" type="video/mp4">
    </video>
    <div class="hero-texto">
        <h1>CONTÁCTANOS</h1>
        <p>Estamos para atenderte. Visítanos, llámanos o escríbenos.</p>
    </div>
</section>

<section class="contenedor">

    <div class="encabezado">
        <span class="chip">Dragon Ice</span>
        <h2>Encuentra la forma más fácil de llegar a nosotros</h2>
    </div>

    <div class="datos">

        <div class="dato">
            <div class="icono">
                <svg viewBox="0 0 24 24"><path d="M12 21s-7-6.4-7-11a7 7 0 0 1 14 0c0 4.6-7 11-7 11z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
            </div>
            <h3>Dirección</h3>
            <p>Av. Heroínas y Lanza #452<br>Cercado, Cochabamba</p>
        </div>

        <div class="dato">
            <div class="icono">
                <svg viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"></path></svg>
            </div>
            <h3>Teléfono</h3>
            <p><a href="tel:+59162622743">62622743</a></p>
        </div>

        <div class="dato">
            <div class="icono">
                <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 7l9 6 9-6"></path></svg>
            </div>
            <h3>Correo</h3>
            <p><a href="mailto:frost@gmail.com">frost@gmail.com</a></p>
        </div>

        <div class="dato">
            <div class="icono">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>
            </div>
            <h3>Horario de atención</h3>
            <p>Todos los días<br>9:00 am a 5:00 pm</p>
        </div>

    </div>

    <div class="ubicacion">
        <div class="imagen">
            <img src="../imagenesproyecto/combo.jpg" alt="Combo Dragon Ice">
        </div>
        <div class="mapa">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d615.3590111624675!2d-66.15389959642064!3d-17.39173143466908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1ses!2sbo!4v1777933507710!5m2!1ses!2sbo"
                loading="lazy"
                title="Ubicación de Dragon Ice">
            </iframe>
        </div>
    </div>

    <div class="redes-bloque">
        <h2>Síguenos en redes</h2>
        <p>Entérate de nuestros nuevos sabores y promociones.</p>

        <div class="redes">
            <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/></svg>
            </a>
            <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><path d="M12 2c2.7 0 3.1 0 4.1.1 1.1 0 1.8.2 2.5.5.7.3 1.2.6 1.8 1.2.6.6.9 1.1 1.2 1.8.3.7.5 1.4.5 2.5.1 1 .1 1.4.1 4.1s0 3.1-.1 4.1c0 1.1-.2 1.8-.5 2.5-.3.7-.6 1.2-1.2 1.8-.6.6-1.1.9-1.8 1.2-.7.3-1.4.5-2.5.5-1 .1-1.4.1-4.1.1s-3.1 0-4.1-.1c-1.1 0-1.8-.2-2.5-.5-.7-.3-1.2-.6-1.8-1.2-.6-.6-.9-1.1-1.2-1.8-.3-.7-.5-1.4-.5-2.5C2 15.1 2 14.7 2 12s0-3.1.1-4.1c0-1.1.2-1.8.5-2.5.3-.7.6-1.2 1.2-1.8.6-.6 1.1-.9 1.8-1.2.7-.3 1.4-.5 2.5-.5C8.9 2 9.3 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 8.2a3.2 3.2 0 1 1 0-6.4 3.2 3.2 0 0 1 0 6.4zm5.2-8.4a1.2 1.2 0 1 1 0-2.4 1.2 1.2 0 0 1 0 2.4z"/></svg>
            </a>
            <a href="#" aria-label="TikTok">
                <svg viewBox="0 0 24 24"><path d="M14 3c.4 2.2 1.9 3.7 4.1 4v3c-1.4 0-2.7-.4-4.1-1.3v6.2A5.9 5.9 0 1 1 8.3 9v3.2a2.7 2.7 0 1 0 2.7 2.7V3H14z"/></svg>
            </a>
        </div>
    </div>

</section>

<section class="cta">
    <h2>¿Tienes alguna duda o sugerencia?</h2>
    <p>Déjanos un mensaje en el buzón o haz tu pedido desde nuestra tienda.</p>
    <a href="../comentarios/formulario.php">Escribir un mensaje</a>
    <a href="productos.php">Ver productos</a>
</section>

<?php include("piedepagina.php"); ?>

</body>
</html>