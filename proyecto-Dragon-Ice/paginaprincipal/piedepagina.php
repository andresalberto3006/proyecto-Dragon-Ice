
<?php
?>

<style>

.pie{
    margin-top:80px;
    background:rgb(125,197,197);
    border-radius:30px 30px 0 0;
    overflow:hidden;
}

.pie-contenido{
    padding:50px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:50px;
}

.pie-info{
    color:black;
}

.pie-info h3{
    font-size:38px;
    margin-bottom:25px;
}

.pie-info p{
    font-size:22px;
    margin-bottom:18px;
    line-height:1.5;
}

.pie-mapa iframe{
    width:100%;
    height:350px;
    border:none;
    border-radius:20px;
}

.pie-copy{
    background:rgb(13, 184, 184);
    color:black;
    text-align:center;
    font-size:20px;
    padding:20px;
    border-top:2px solid rgba(255,255,255,0.3);
}

@media(max-width:900px){

    .pie-contenido{
        grid-template-columns:1fr;
    }

    .pie-info{
        text-align:center;
    }

}
</style>

<footer class="pie">

    <div class="pie-contenido">

        <div class="pie-info">
            <h3>📞 Contacto</h3>

            <p><strong>Teléfono:</strong> 62622743</p>

            <p><strong>Correo:</strong> frost@gmail.com</p>

            <p><strong>Ubicación:</strong><br>
            Av. Heroínas y Lanza #452</p>
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
        🍦 © 2025 Dragon Ice | Helados Artesanales
    </div>

</footer>

