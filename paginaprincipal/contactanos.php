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
    width:100%;
    height:100vh;
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
    background:rgba(14,42,77,0.5);
}

.hero-texto{
    position:relative;
    z-index:2;
    text-align:center;
    color:white;
    padding:0 20px;
}

.hero-texto h1{
    font-size:90px;
    letter-spacing:10px;
    text-shadow:0 0 15px rgba(0,0,0,0.6);
}

.hero-texto p{
    margin-top:14px;
    font-size:20px;
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


.equipo{
    margin-top:80px;
}

.equipo-grid{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:24px;
}

.miembro{
    width:320px;
    border:1px solid #e2edf5;
    border-radius:16px;
    padding:28px 22px;
    text-align:center;
}

.miembro img{
    width:150px;
    height:150px;
    border-radius:50%;
    object-fit:cover;
    object-position:center top;
    margin-bottom:14px;
}

.miembro img.andre{
    object-position:center 65%;
}

.miembro h3{
    font-size:22px;
    margin-bottom:4px;
}

.miembro .oficio{
    color:#159db9;
    font-weight:700;
    font-size:14px;
    margin-bottom:12px;
}

.miembro .descripcion{
    font-size:14.5px;
    line-height:1.6;
    color:var(--gris-texto);
    margin-bottom:12px;
}

.miembro .telefono{
    font-size:15px;
    font-weight:700;
}

.miembro .telefono a{
    color:var(--azul-oscuro);
    text-decoration:none;
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
    .hero-texto h1{ font-size:44px; letter-spacing:4px; }
    .encabezado h2{ font-size:28px; }
}

@media(max-width:520px){
    .datos{ grid-template-columns:1fr; }
    .miembro{ width:100%; }
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


    <div class="equipo">

        <div class="encabezado">
            <span class="chip">Frost S.A.</span>
            <h2>Nuestro equipo</h2>
        </div>

        <div class="equipo-grid">

            <div class="miembro">
                <img src="../imagenesproyecto/camila.jpg" alt="Camila Vargas">
                <h3>Camila Vargas</h3>
                <p class="oficio">Representante legal</p>
                <p class="descripcion">Representa a la empresa ante clientes y entidades, y vela por que Dragon Ice cumpla con sus compromisos y normativas.</p>
                <p class="telefono">📞 <a href="tel:+59162622743">62622743</a></p>
            </div>

            <div class="miembro">
                <img src="../imagenesproyecto/agustin.jpg" alt="Agustin Veizaga">
                <h3>Agustin Veizaga</h3>
                <p class="oficio">Jefe de desarrollo</p>
                <p class="descripcion">Lidera la construcción del sistema web de Dragon Ice y coordina al equipo técnico para mantenerlo funcionando.</p>
                <p class="telefono">📞 <a href="tel:+59169436981">69436981</a></p>
            </div>

            <div class="miembro">
                <img src="../imagenesproyecto/edson.jpg" alt="Edson Torrico">
                <h3>Edson Torrico</h3>
                <p class="oficio">Jefe de investigaciones</p>
                <p class="descripcion">Investiga nuevas ideas, sabores y tendencias para que Dragon Ice siga innovando en cada producto.</p>
                <p class="telefono">📞 <a href="tel:+59176884361">76884361</a></p>
            </div>

            <div class="miembro">
                <img src="../imagenesproyecto/andre.jpg" alt="Andre Aramayo" class="andre">
                <h3>Andre Aramayo</h3>
                <p class="oficio">Jefe de control de calidad</p>
                <p class="descripcion">Revisa que cada producto y cada función del sistema cumplan con el nivel de calidad que esperan nuestros clientes.</p>
                <p class="telefono">📞 <a href="tel:+59164740198">64740198</a></p>
            </div>

            <div class="miembro">
                <img src="../imagenesproyecto/andres.jpg" alt="Andres Alberto">
                <h3>Andres Alberto</h3>
                <p class="oficio">Administración de la base de datos</p>
                <p class="descripcion">Administra y protege la información del negocio: productos, pedidos, ventas y usuarios.</p>
                <p class="telefono">📞 <a href="tel:+59172791232">72791232</a></p>
            </div>

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