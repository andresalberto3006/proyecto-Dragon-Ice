<?php
?>

<style>
:root{
    --noche-glaciar:#071426;
    --azul-profundo:#0e2a4d;
    --celeste:#63d4f2;
    --celeste-brillo:#a8ecff;
    --menta:#7be0c4;
    --blanco:#ffffff;
    --texto-suave:#c7ddec;
}

.pie{
    margin-top:0;
    position:relative;
    background:
        radial-gradient(circle at 10% 0%, rgba(99,212,242,0.16), transparent 45%),
        radial-gradient(circle at 90% 100%, rgba(123,224,196,0.14), transparent 45%),
        linear-gradient(150deg, var(--noche-glaciar) 0%, var(--azul-profundo) 100%);
    overflow:hidden;
    font-family:'Inter', Arial, sans-serif;
}

/* destellos flotando, igual que en el menú */
.pie .destello{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.55);
    filter:blur(0.5px);
    opacity:0;
    animation:pie-brillar 6s ease-in-out infinite;
    pointer-events:none;
}
.pie .d1{ width:4px; height:4px; top:30px; left:8%; animation-delay:0.3s; }
.pie .d2{ width:3px; height:3px; top:80px; left:34%; animation-delay:2.2s; }
.pie .d3{ width:5px; height:5px; top:50px; left:60%; animation-delay:1.3s; }
.pie .d4{ width:3px; height:3px; top:110px; left:88%; animation-delay:3s; }

@keyframes pie-brillar{
    0%, 100%{ opacity:0; transform:translateY(0) scale(1); }
    50%{ opacity:0.9; transform:translateY(-8px) scale(1.3); }
}

.pie-contenido{
    position:relative;
    padding:60px 50px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:50px;
}

.pie-info h3{
    font-family:'Baloo 2', cursive;
    font-size:32px;
    font-weight:800;
    margin-bottom:26px;
    background:linear-gradient(90deg, var(--blanco) 0%, var(--celeste-brillo) 60%, var(--menta) 100%);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    display:inline-block;
}

.pie-dato{
    display:flex;
    align-items:flex-start;
    gap:14px;
    margin-bottom:20px;
    padding:14px 18px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    transition:transform 0.3s cubic-bezier(.34,1.56,.64,1), background 0.3s ease, box-shadow 0.3s ease;
}

.pie-dato:hover{
    transform:translateY(-4px);
    background:rgba(255,255,255,0.09);
    box-shadow:0 10px 24px rgba(99,212,242,0.18);
}

.pie-dato .icono-pie{
    flex-shrink:0;
    width:38px;
    height:38px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(145deg, rgba(99,212,242,0.25), rgba(123,224,196,0.15));
    border:1px solid rgba(255,255,255,0.15);
}

.pie-dato .icono-pie svg{
    width:19px;
    height:19px;
    stroke:var(--celeste-brillo);
    fill:none;
    stroke-width:1.8;
}

.pie-dato .texto-dato{
    color:var(--texto-suave);
    font-size:16px;
    line-height:1.5;
}

.pie-dato .texto-dato strong{
    display:block;
    color:var(--blanco);
    font-size:14px;
    font-weight:700;
    letter-spacing:0.4px;
    text-transform:uppercase;
    margin-bottom:3px;
}

.pie-mapa iframe{
    width:100%;
    height:340px;
    border:none;
    border-radius:20px;
    filter:saturate(0.9) brightness(0.95);
    border:1px solid rgba(255,255,255,0.12);
}

.pie-copy{
    position:relative;
    background:linear-gradient(120deg, var(--celeste), var(--menta));
    color:var(--noche-glaciar);
    text-align:center;
    font-size:15px;
    font-weight:700;
    letter-spacing:0.3px;
    padding:18px;
}

@media(max-width:900px){

    .pie-contenido{
        grid-template-columns:1fr;
        padding:44px 26px;
    }

    .pie-info{
        text-align:center;
    }

    .pie-dato{
        text-align:left;
    }
}
</style>

<footer class="pie">
    <span class="destello d1"></span>
    <span class="destello d2"></span>
    <span class="destello d3"></span>
    <span class="destello d4"></span>

    <div class="pie-contenido">

        <div class="pie-info">
            <h3>Contacto</h3>

            <div class="pie-dato">
                <span class="icono-pie">
                    <svg viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.1-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.5 2.1L8 9.7a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.7 2z"></path></svg>
                </span>
                <div class="texto-dato">
                    <strong>Teléfono</strong>
                    62622743
                </div>
            </div>

            <div class="pie-dato">
                <span class="icono-pie">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path><path d="M22 6l-10 7L2 6"></path></svg>
                </span>
                <div class="texto-dato">
                    <strong>Correo</strong>
                    frost@gmail.com
                </div>
            </div>

            <div class="pie-dato">
                <span class="icono-pie">
                    <svg viewBox="0 0 24 24"><path d="M12 21s-7-6.4-7-11a7 7 0 0 1 14 0c0 4.6-7 11-7 11z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
                </span>
                <div class="texto-dato">
                    <strong>Ubicación</strong>
                    Av. Heroínas y Lanza #452
                </div>
            </div>
        </div>

        <div class="pie-mapa">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d951.8538846511874!2d-66.15444203036925!3d-17.391834719174938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93e373f8a49eaf75%3A0xc9337e878bf0dab9!2sInternet%20y%20Cabinas%20EDGAR!5e0!3m2!1ses!2sbo!4v1781896843542!5m2!1ses!2sbo"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>

    <div class="pie-copy">
        🍦 © 2026 Dragon Ice | Helados Artesanales
    </div>

</footer>