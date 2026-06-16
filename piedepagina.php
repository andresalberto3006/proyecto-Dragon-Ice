<style>

.footer{
    background: #83b9ff;
    color: #333;
    margin-top: 80px;
    border-top: 2px solid #48a4fa;
    box-shadow: 0 -5px 15px rgba(0,0,0,0.08);
}

.footer-contenido{
    display:flex;
    justify-content:space-between;
    gap:40px;
    padding:50px 10%;
    flex-wrap:wrap;
}

.footer-info{
    flex:1;
    min-width:300px;
}

.footer-info h2{
    font-size:32px;
    margin-bottom:20px;
}

.footer-info p{
    margin-bottom:12px;
    font-size:18px;
}

.footer-mapa iframe{
    width:100%;
    height:250px;
    border:none;
    border-radius:15px;
}

.footer-copy{
    text-align:center;
    padding:15px;
    background:#5c86f8;
    color:white;
}

@media(max-width:768px){
    .footer-contenido{
        flex-direction:column;
        text-align:center;
    }
}

</style>

<footer class="footer">

    <div class="footer-contenido">

        <div class="footer-info">
            <h2>📞 Contacto</h2>
            <p>Teléfono: 62622743</p>
            <p>Correo: frost@gmail.com</p>
            <p>Ubicación: Av. Heroínas y Lanza #452</p>
        </div>

        <div class="footer-mapa">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d615.3590111624675!2d-66.15389959642064!3d-17.39173143466908"></iframe>
        </div>

    </div>

    <div class="footer-copy">
        🍦 © 2025 Dragon Ice | Helados Artesanales
    </div>

</footer>