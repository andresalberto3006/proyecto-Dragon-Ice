<?php
if (!isset($rutaMenu)) { $rutaMenu = "../"; }
?>

<style>

:root{
    --azul-oscuro:#0e2a4d;
    --celeste:#29a8e0;
    --gris-texto:#6b7280;
    --gris-titulo:#374151;
    --gris-borde:#e5e7eb;
}

.pie{
    background:#0e2a4d;
    font-family:'Inter', Arial, sans-serif;
    padding-top:40px;
}

.pie-contenido{
    max-width:1200px;
    margin:0 auto;
    padding:40px 24px;
    display:grid;
    grid-template-columns:1.3fr 1fr 1fr 1fr;
    gap:30px;
}

.pie-marca{
    display:flex;
    align-items:center;
    gap:12px;
}

.pie-marca img{
    border-radius:100px;
    width:80px;
    height:80px;
    object-fit:contain;
}

.pie-marca h2{
    font-family:'Baloo 2', Arial, sans-serif;
    font-size:20px;
    font-weight:800;
    color:white;
    margin-bottom:6px;
}

.pie-marca p{
    font-size:13px;
    letter-spacing:1px;
    color:var(--gris-texto);
    text-transform:uppercase;
}

.pie-col h3{
    font-size:15px;
    font-weight:700;
    color:white;
    margin-bottom:16px;
    text-align:center;
}

.pie-col ul{
    list-style:none;
}

.pie-col li{
    margin-bottom:12px;
    text-align:center;
}

.pie-col a{
    text-decoration:none;
    color:var(--gris-texto);
    font-size:14px;
}

.pie-col a:hover{
    color:var(--celeste);
}

.pie-contacto p{
    color:var(--gris-texto);
    font-size:14px;
    text-align:center;
    margin-bottom:10px;
    line-height:1.5;
}

.pie-redes{
    display:flex;
    justify-content:center;
    gap:12px;
}

.pie-redes a{
    width:38px;
    height:38px;
    border-radius:50%;
    background:#9ca3af;
    display:flex;
    align-items:center;
    justify-content:center;
}

.pie-redes a:hover{
    background:var(--celeste);
}

.pie-redes svg{
    width:17px;
    height:17px;
    fill:white;
}

.pie-copy{
    border-top:1px solid rgba(255,255,255,0.15);
    text-align:center;
    padding:18px;
    font-size:13px;
    color:var(--gris-texto);
}

@media(max-width:900px){
    .pie-contenido{
        grid-template-columns:1fr 1fr;
    }
    .pie-marca{
        grid-column:1 / -1;
        margin-bottom:10px;
    }
}

@media(max-width:600px){
    .pie-contenido{
        grid-template-columns:1fr;
    }
}
</style>

<footer class="pie">

    <div class="pie-contenido">

        <div class="pie-marca">
            <img src="<?php echo $rutaMenu; ?>imagenesproyecto/logo.png" alt="Logo Dragon Ice">
            <div>
                <h2>Dragon Ice</h2>
                <p>Helados Artesanales</p>
            </div>
        </div>

        <div class="pie-col">
            <h3>Dragon Ice</h3>
            <ul>
                <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/01.inicio.php">Inicio</a></li>
                <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/productos.php">Productos</a></li>
                <li><a href="<?php echo $rutaMenu; ?>quienessomos.php">Sobre nosotros</a></li>
            </ul>
        </div>

       <div class="pie-col pie-contacto">
            <h3>Contacto</h3>
            <p>Av. Heroínas y Lanza #452</p>
            <p>62622743</p>
            <p>frost@gmail.com</p>
        </div>

        <div class="pie-col">
            <h3>Redes</h3>
            <div class="pie-redes">
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

    </div>

    <div class="pie-copy">
        © 2026 Dragon Ice | Helados Artesanales — Todos los derechos reservados
    </div>

</footer>