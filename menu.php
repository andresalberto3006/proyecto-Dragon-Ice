<?php
if (session_status() == PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}
if (!isset($rutaMenu)) {
    $rutaMenu = "";
}
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
:root{
    --fondo-1:#0b1f22;
    --fondo-2:#123338;
    --fondo-3:#1b4a52;
    --celeste:#63d4f2;
    --menta:#7be0c4;
    --blanco:#ffffff;
    --texto-suave:#c7ddec;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

.dragonice-nav{
    font-family:'Inter', Arial, sans-serif;
    width:100%;
    background:#0e2a4d;
    position:sticky;
    top:0;
    z-index:1000;
    border-bottom:1px solid rgba(255,255,255,0.08);
}
.dragonice-nav .fila{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:16px 40px;
    gap:20px;
}

.dragonice-nav .logo{
    display:flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    flex-shrink:0;
}

.dragonice-nav .logo img{
    width:32px;
    height:32px;
    border-radius:50%;
    object-fit:cover;
}

.dragonice-nav .logo h2{
    font-family:'Baloo 2', cursive;
    font-size:24px;
    font-weight:700;
    color:var(--celeste);
    white-space:nowrap;
}

.dragonice-nav .nav-links{
    display:flex;
    align-items:center;
    list-style:none;
    gap:26px;
    flex:1;
    margin-left:40px;
}

.dragonice-nav .nav-links a{
    text-decoration:none;
    color:var(--texto-suave);
    font-size:15px;
    font-weight:600;
    transition:color 0.2s ease;
}

.dragonice-nav .nav-links a:hover{
    color:var(--celeste);
}

.dragonice-nav .iconos{
    display:flex;
    align-items:center;
    gap:6px;
    flex-shrink:0;
}

.dragonice-nav .icono-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    width:38px;
    height:38px;
    border-radius:50%;
    color:var(--texto-suave);
    text-decoration:none;
    transition:background 0.2s ease, color 0.2s ease;
    position:relative;
}

.dragonice-nav .icono-btn svg{
    width:19px;
    height:19px;
    stroke:currentColor;
    fill:none;
    stroke-width:1.8;
}

.dragonice-nav .icono-btn:hover{
    background:rgba(255,255,255,0.1);
    color:var(--celeste);
}

.dragonice-nav .icono-btn .badge{
    position:absolute;
    top:-2px;
    right:-2px;
    background:var(--menta);
    color:var(--fondo-1);
    font-size:10px;
    font-weight:700;
    min-width:16px;
    height:16px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0 3px;
}

.dragonice-nav .sesion-texto{
    font-size:14px;
    font-weight:700;
    color:var(--fondo-1);
    text-decoration:none;
    padding:9px 18px;
    border-radius:20px;
    background:var(--celeste);
    white-space:nowrap;
    transition:background 0.2s ease;
}

.dragonice-nav .sesion-texto:hover{
    background:var(--menta);
}

.dragonice-nav .btn-menu{
    display:none;
    background:none;
    border:none;
    color:var(--blanco);
    font-size:1.6rem;
    cursor:pointer;
}

@media(max-width:900px){

    .dragonice-nav .btn-menu{
        display:block;
    }

    .dragonice-nav .fila{
        flex-wrap:wrap;
        padding:14px 20px;
    }

    .dragonice-nav .nav-links{
        display:none;
        flex-direction:column;
        width:100%;
        order:4;
        margin:14px 0 0 0;
        gap:12px;
    }

    .dragonice-nav .nav-links.active{
        display:flex;
    }
}
</style>

<nav class="dragonice-nav">
    <div class="fila">

        <a href="<?php echo $rutaMenu; ?>paginaprincipal/01.inicio.php" class="logo">
            <img src="<?php echo $rutaMenu; ?>imagenesproyecto/logo.png" alt="Logo Dragon Ice">
            <h2>Dragon Ice</h2>
        </a>

        <button class="btn-menu" id="btnMenu" aria-label="Abrir menú">☰</button>

        <ul class="nav-links" id="navLinks">
            <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/01.inicio.php">Inicio</a></li>
            <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/productos.php">Productos</a></li>
            <li><a href="<?php echo $rutaMenu; ?>quienessomos.php">Quiénes somos</a></li>
        </ul>

        <div class="iconos">
            <a href="<?php echo $rutaMenu; ?>buscar.php" class="icono-btn" aria-label="Buscar">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </a>
            <a href="<?php echo $rutaMenu; ?>ubicacion.php" class="icono-btn" aria-label="Ubicación">
                <svg viewBox="0 0 24 24"><path d="M12 21s-7-6.4-7-11a7 7 0 0 1 14 0c0 4.6-7 11-7 11z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
            </a>

            <?php if (isset($_SESSION['rol'])) { ?>
                <?php if ($_SESSION['rol'] == 'Administrador') { ?>
                    <a href="<?php echo $rutaMenu; ?>paginaprincipal/02.admin.php" class="icono-btn" aria-label="Mi panel">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-1a7 7 0 0 0-14 0v1"></path><circle cx="13" cy="7" r="4"></circle></svg>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo $rutaMenu; ?>paginaprincipal/vendedor20.php" class="icono-btn" aria-label="Mi panel">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-1a7 7 0 0 0-14 0v1"></path><circle cx="13" cy="7" r="4"></circle></svg>
                    </a>
                <?php } ?>
                <a href="<?php echo $rutaMenu; ?>cerrar1.php" class="sesion-texto">Cerrar sesión</a>
            <?php } else { ?>
                <a href="<?php echo $rutaMenu; ?>iniciosesion.php" class="icono-btn" aria-label="Iniciar sesión">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-1a7 7 0 0 0-14 0v1"></path><circle cx="13" cy="7" r="4"></circle></svg>
                </a>
            <?php } ?>

            <?php if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') { ?>
                <a href="<?php echo $rutaMenu; ?>pedidos/formpedido.php" class="icono-btn" aria-label="Carrito de compras">
                    <svg viewBox="0 0 24 24"><path d="M3 4h2l2.4 12.4a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.6L21 8H6"></path><circle cx="9" cy="21" r="1.4"></circle><circle cx="18" cy="21" r="1.4"></circle></svg>
                    <?php if (isset($_SESSION['carrito_cantidad']) && $_SESSION['carrito_cantidad'] > 0) { ?>
                        <span class="badge"><?php echo $_SESSION['carrito_cantidad']; ?></span>
                    <?php } ?>
                </a>
            <?php } ?>
        </div>

    </div>
</nav>

<script>
const btnMenu = document.getElementById("btnMenu");
const navLinks = document.getElementById("navLinks");
if (btnMenu) {
    btnMenu.addEventListener("click", function(){
        navLinks.classList.toggle("active");
    });
}
document.querySelectorAll("#navLinks a").forEach(function(link) {
    link.addEventListener("click", function() {
        navLinks.classList.remove("active");
    });
});
</script>