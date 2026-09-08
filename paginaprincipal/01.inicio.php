<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dragon Ice | Helados Artesanales</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>

    :root{
        --azul-oscuro:#0e2a4d;
        --celeste:#29a8e0;
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


    .hero{
        position:relative;
        width:100%;
        height:100vh;
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

    .hero main{
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        z-index:5;
    }

    .hero main h1{
        color:white;
        font-size:110px;
        font-weight:bold;
        letter-spacing:14px;
        text-shadow:
            0 0 15px rgba(0,0,0,0.8),
            0 0 30px rgba(0,0,0,0.7);
    }

    @media(max-width:700px){
        .hero main h1{
            font-size:55px;
            letter-spacing:6px;
            text-align:center;
        }
    }


   .confianza{
    padding: 70px 20px;
    background: #b6cee4;
}

.confianza-header{
    text-align: center;
    max-width: 600px;
    margin: 0 auto 50px;
}

.confianza-eyebrow{
    display: inline-block;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #12175a;
    margin-bottom: 10px;
}

.confianza-header h2{
    font-size: 32px;
    color: #2b1a12;
    font-weight: 700;
}

.confianza-grid{
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.item{
    background: #ffffff;
    padding: 40px 28px;
    border-radius: 18px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(14, 42, 77, .08);
    border: 1px solid #e2edf5;
    transition: transform .3s ease, box-shadow .3s ease;
}

.item:hover{
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(14, 42, 77, .16);
}

.icono{
    width: 62px;
    height: 62px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eaf8fc;
    color: #159db9;
}

.item h3{
    font-size: 17px;
    letter-spacing: .3px;
    color: #0e2a4d;
    margin-bottom: 10px;
    font-weight: 700;
}

.item p{
    font-size: 14.5px;
    line-height: 1.65;
    color: #5b7590;
}

@media(max-width: 800px){
    .porque-grid{
        grid-template-columns: 1fr;
        gap: 20px;
    }
}


    .seccion{
        max-width:1250px;
        margin:110px auto;
        padding:0 30px;
        display:grid;
        grid-template-columns:1fr 1.2fr;
        gap:60px;
        align-items:center;
    }

    .seccion.invertida .imagen{
        order:-1;
    }

    .seccion .chip{
        font-size:14px;
        font-weight:700;
        letter-spacing:2px;
        text-transform:uppercase;
        color:var(--celeste);
        margin-bottom:14px;
    }

    .seccion h2{
        font-size:50px;
        line-height:1.1;
        color:var(--azul-oscuro);
        margin-bottom:22px;
    }

    .seccion p{
        font-size:18px;
        line-height:1.8;
        color:var(--gris-texto);
        margin-bottom:28px;
    }

    .seccion a{
        display:inline-block;
        text-decoration:none;
        background:var(--azul-oscuro);
        color:white;
        font-weight:700;
        padding:15px 34px;
        border-radius:30px;
        transition:.25s;
    }

    .seccion a:hover{
        background:var(--celeste);
        color:var(--azul-oscuro);
    }

    .seccion img{
        width:100%;
        height:550px;
        object-fit:cover;
        border-radius:22px;
        box-shadow:0 20px 45px rgba(0,0,0,0.2);
    }

    @media(max-width:900px){
        .seccion{ grid-template-columns:1fr; margin:60px auto; }
        .seccion.invertida .imagen{ order:0; }
        .seccion h2{ font-size:34px; }
        .seccion img{ height:320px; }
    }


  .porque{
    padding: 70px 20px;
    background: #f4fbfd;
}

.porque-header{
    text-align: center;
    max-width: 600px;
    margin: 0 auto 50px;
}

.porque-eyebrow{
    display: inline-block;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #159db9;
    margin-bottom: 10px;
}

.porque-titulo{
    font-size: 32px;
    color: #0e2a4d;
    font-weight: 700;
}

.porque-grid{
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

    .lobueno{
        position:relative;
        height:520px;
        display:flex;
        align-items:center;
        justify-content:center;
        overflow:hidden;
    }

    .lobueno img{
        position:absolute;
        inset:0;
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .lobueno::after{
        content:"";
        position:absolute;
        inset:0;
        background:rgba(5,11,22,0.5);
    }

    .lobueno-texto{
        position:relative;
        z-index:2;
        text-align:center;
        color:white;
        padding:0 20px;
        max-width:650px;
    }

    .lobueno-texto h2{
        font-size:42px;
        letter-spacing:2px;
        margin-bottom:18px;
    }

    .lobueno-texto p{
        font-size:17px;
        line-height:1.7;
        color:#e6f3ff;
        margin-bottom:26px;
    }

    .lobueno-texto a{
        display:inline-block;
        text-decoration:none;
        background:var(--celeste);
        color:var(--azul-oscuro);
        font-weight:700;
        padding:14px 32px;
        border-radius:30px;
        transition:.25s;
    }

    .lobueno-texto a:hover{
        background:var(--menta);
    }

    @media(max-width:700px){
        .lobueno-texto h2{ font-size:28px; }
    }


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

    </style>
</head>

<body>

<header class="menu-principal">
    <?php $rutaMenu = "../"; include("../menu.php"); ?>
</header>

<section class="hero">
    <video autoplay muted loop>
        <source src="../helado1.mp4" type="video/mp4">
    </video>

    <main>
        <h1>DRAGON ICE</h1>
    </main>
</section>

<section class="confianza">

    <div class="confianza-header">
        <span class="confianza-eyebrow">Por qué elegirnos</span>
        <h2>El sabor de lo hecho a mano</h2>
    </div>

    <div class="confianza-grid">

        <div class="item">
            <div class="icono">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2c-3.5 0-6 2.7-6 6 0 1.2.3 2.3.9 3.3L5 21h14l-1.9-9.7c.6-1 .9-2.1.9-3.3 0-3.3-2.5-6-6-6z"/>
                    <path d="M9 12h6"/>
                </svg>
            </div>
            <h3>100% Artesanal</h3>
            <p>Cada tanda se hace a mano, sin atajos ni procesos industriales.</p>
        </div>

        <div class="item">
            <div class="icono">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="13" r="8"/>
                    <path d="M12 5V3M9 3h6"/>
                </svg>
            </div>
            <h3>Ingredientes Frescos</h3>
            <p>Fruta real, leche fresca y sabores que se notan desde la primera cucharada.</p>
        </div>

        <div class="item">
            <div class="icono">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <h3>Recetas Propias</h3>
            <p>Combinaciones creadas por nosotros, pensadas para sorprenderte.</p>
        </div>

    </div>

</section>

<section class="seccion">
    <div>
        <div class="chip">Nuestro catálogo</div>
        <h2>Un sabor para cada antojo</h2>
        <p>Paletas, bolos, tacos, granizados y combos especiales de la casa. Cada receta está pensada para que encuentres ese sabor que se te queda grabado desde la primera cucharada.</p>
        <a href="productos.php">Ver catálogo completo</a>
    </div>
    <div class="imagen">
        <img src="../imagenesproyecto/combo.jpg" alt="Sabores Dragon Ice">
    </div>
</section>

<section class="seccion invertida">
    <div>
        <div class="chip">Nuestra esencia</div>
        <h2>Artesanal desde el primer scoop</h2>
        <p>Nada de químicos raros ni atajos industriales. Dragon Ice nació de una idea simple: ingredientes de verdad, recetas propias y el cariño de hacer las cosas bien, cucharada tras cucharada.</p>
        <a href="../quienessomos.php">Conócenos más</a>
    </div>
    <div class="imagen">
        <img src="../imagenesproyecto/brownie.jpg" alt="Helado artesanal Dragon Ice">
    </div>
</section>

<section class="porque">

    <div class="porque-header">
        <span class="porque-eyebrow">Dragon Ice</span>
        <h2 class="porque-titulo">¿Por qué elegir Dragon Ice?</h2>
    </div>

    <div class="porque-grid">

        <div class="item">
            <div class="icono">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2c-3.5 0-6 2.6-6 5.8 0 1.1.3 2.2.9 3.1L5 21h14l-1.9-10.1c.6-.9.9-2 .9-3.1C18 4.6 15.5 2 12 2z"/>
                    <path d="M9 11.5h6"/>
                </svg>
            </div>
            <h3>Sabores Únicos</h3>
            <p>Combinaciones que no vas a encontrar en cualquier heladería, creadas con recetas propias de la casa.</p>
        </div>

        <div class="item">
            <div class="icono">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8L12 3 3 8l9 5 9-5z"/>
                    <path d="M3 8v8l9 5 9-5V8"/>
                    <path d="M12 13v8"/>
                </svg>
            </div>
            <h3>Cuidado en Cada Detalle</h3>
            <p>Preparamos y empacamos cada pedido con cuidado para que llegue en su punto perfecto.</p>
        </div>

        <div class="item">
            <div class="icono">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="6" cy="19" r="2.5"/>
                    <circle cx="18" cy="19" r="2.5"/>
                    <path d="M8.2 19h7.6M18 19l-2.5-8h-4L9 15H5.5"/>
                    <path d="M11.5 11L14 6h3"/>
                </svg>
            </div>
            <h3>Entrega Rápida</h3>
            <p>Pide tu helado y te lo llevamos fresco, directo a tu puerta o listo para recoger en tienda.</p>
        </div>

    </div>

</section>
<section class="lobueno">
    <img src="../imagenesproyecto/ensalada.jpg" alt="Todo lo bueno Dragon Ice">
    <div class="lobueno-texto">
        <h2>TODO LO BUENO</h2>
        <p>Creemos en usar ingredientes reales, apoyar a proveedores locales y hacer las cosas con calma y calidad. Así preparamos cada helado, desde la primera hasta la última cucharada.</p>
        <a href="../quienessomos.php">Conoce más</a>
    </div>
</section>

<section class="cta">
    <h2>¿Listo para probarlo?</h2>
    <p>Descubre todo nuestro catálogo de helados artesanales.</p>
    <a href="productos.php">Ver productos</a>
</section>

<?php include("piedepagina.php"); ?>

</body>
</html>