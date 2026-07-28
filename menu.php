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
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --noche-glaciar:#071426;
    --azul-profundo:#0e2a4d;
    --azul-vidrio:rgba(255,255,255,0.06);
    --celeste:#63d4f2;
    --celeste-brillo:#a8ecff;
    --menta:#7be0c4;
    --blanco:#ffffff;
    --texto-suave:#c7ddec;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* ---------- Contenedor con fondo helado ---------- */
.dragonice-nav{
    font-family:'Inter', Arial, sans-serif;
    width:100%;
    background:
        radial-gradient(circle at 15% 0%, rgba(99,212,242,0.18), transparent 45%),
        radial-gradient(circle at 85% 100%, rgba(123,224,196,0.14), transparent 45%),
        linear-gradient(120deg, var(--noche-glaciar) 0%, var(--azul-profundo) 100%);
    position:sticky;
    top:0;
    z-index:1000;
    overflow:visible;
}

/* pequeños destellos de "hielo" flotando en el fondo */
.dragonice-nav .destello{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.55);
    filter:blur(0.5px);
    opacity:0;
    animation:brillar 5s ease-in-out infinite;
    pointer-events:none;
}
.dragonice-nav .d1{ width:4px; height:4px; top:14px; left:12%; animation-delay:0.2s; }
.dragonice-nav .d2{ width:3px; height:3px; top:34px; left:38%; animation-delay:1.8s; }
.dragonice-nav .d3{ width:5px; height:5px; top:20px; left:63%; animation-delay:1s; }
.dragonice-nav .d4{ width:3px; height:3px; top:44px; left:82%; animation-delay:2.6s; }

@keyframes brillar{
    0%, 100%{ opacity:0; transform:translateY(0) scale(1); }
    50%{ opacity:0.9; transform:translateY(-6px) scale(1.3); }
}

.dragonice-nav .fila{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:14px 40px;
    gap:20px;
    border-bottom:1px solid rgba(255,255,255,0.08);
}

/* ---------- Logo ---------- */
.dragonice-nav .logo{
    display:flex;
    align-items:center;
    gap:10px;
    text-decoration:none;
    flex-shrink:0;
    group:logo;
}

.dragonice-nav .logo .icono-cono{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:12px;
    background:linear-gradient(145deg, rgba(99,212,242,0.25), rgba(123,224,196,0.15));
    border:1px solid rgba(255,255,255,0.15);
    transition:transform 0.4s cubic-bezier(.34,1.56,.64,1), box-shadow 0.4s ease;
}

.dragonice-nav .logo:hover .icono-cono{
    transform:rotate(-12deg) scale(1.08);
    box-shadow:0 0 18px rgba(99,212,242,0.5);
}

.dragonice-nav .logo .icono-cono img{
    width:26px;
    height:26px;
    object-fit:contain;
}

.dragonice-nav .logo h2{
    font-family:'Baloo 2', cursive;
    font-size:26px;
    font-weight:800;
    letter-spacing:0.3px;
    white-space:nowrap;
    background:linear-gradient(90deg, var(--blanco) 0%, var(--celeste-brillo) 60%, var(--menta) 100%);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
}

/* ---------- Links de navegación ---------- */
.dragonice-nav .nav-links{
    display:flex;
    align-items:center;
    list-style:none;
    gap:8px;
    flex:1;
    margin-left:36px;
}

.dragonice-nav .nav-links a{
    position:relative;
    display:inline-flex;
    align-items:center;
    text-decoration:none;
    color:var(--texto-suave);
    font-size:14.5px;
    font-weight:600;
    letter-spacing:0.4px;
    padding:9px 18px;
    border-radius:24px;
    isolation:isolate;
    overflow:hidden;
    transition:color 0.35s ease;
}

.dragonice-nav .nav-links a::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(120deg, var(--celeste), var(--celeste-brillo));
    border-radius:24px;
    transform:scale(0.4);
    opacity:0;
    z-index:-1;
    transition:transform 0.35s cubic-bezier(.34,1.56,.64,1), opacity 0.3s ease;
}

.dragonice-nav .nav-links a:hover{
    color:var(--noche-glaciar);
}

.dragonice-nav .nav-links a:hover::before{
    transform:scale(1);
    opacity:1;
}

/* ---------- Iconos (derecha) ---------- */
.dragonice-nav .iconos{
    display:flex;
    align-items:center;
    gap:4px;
    flex-shrink:0;
}

.dragonice-nav .icono-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    width:40px;
    height:40px;
    border-radius:50%;
    color:var(--texto-suave);
    text-decoration:none;
    transition:color 0.3s ease, background 0.3s ease, transform 0.3s cubic-bezier(.34,1.56,.64,1);
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
    color:var(--noche-glaciar);
    background:linear-gradient(145deg, var(--celeste-brillo), var(--blanco));
    transform:translateY(-3px);
    box-shadow:0 8px 18px rgba(99,212,242,0.35);
}

.dragonice-nav .icono-btn .badge{
    position:absolute;
    top:-3px;
    right:-3px;
    background:var(--menta);
    color:var(--noche-glaciar);
    font-size:10px;
    font-weight:700;
    min-width:17px;
    height:17px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0 3px;
    box-shadow:0 0 0 2px var(--azul-profundo);
}

.dragonice-nav .sesion-texto{
    font-size:13.5px;
    font-weight:700;
    color:var(--noche-glaciar);
    text-decoration:none;
    padding:10px 20px;
    border-radius:22px;
    background:linear-gradient(120deg, var(--celeste), var(--menta));
    transition:transform 0.3s cubic-bezier(.34,1.56,.64,1), box-shadow 0.3s ease;
    white-space:nowrap;
}

.dragonice-nav .sesion-texto:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(99,212,242,0.4);
}

/* ---------- Botón hamburguesa (mobile) ---------- */
.dragonice-nav .btn-menu{
    display:none;
    background:none;
    border:none;
    color:var(--blanco);
    font-size:1.8rem;
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
        gap:6px;
    }

    .dragonice-nav .nav-links.active{
        display:flex;
    }

    .dragonice-nav .nav-links a{
        width:100%;
        justify-content:center;
    }
}
</style>

<nav class="dragonice-nav">
    <span class="destello d1"></span>
    <span class="destello d2"></span>
    <span class="destello d3"></span>
    <span class="destello d4"></span>

    <div class="fila">

        <a href="<?php echo $rutaMenu; ?>paginaprincipal/01.inicio.php" class="logo">
            <span class="icono-cono">
                <img src="<?php echo $rutaMenu; ?>imagenesproyecto/logo.png" alt="Logo Dragon Ice">
            </span>
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
                    <a href="<?php echo $rutaMenu; ?>paginaprincipal/04.vendedor.php" class="icono-btn" aria-label="Mi panel">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-1a7 7 0 0 0-14 0v1"></path><circle cx="13" cy="7" r="4"></circle></svg>
                    </a>
                <?php } ?>
                <a href="<?php echo $rutaMenu; ?>cerrar1.php" class="sesion-texto">Cerrar sesión</a>
            <?php } else { ?>
                <a href="<?php echo $rutaMenu; ?>iniciosesion.php" class="icono-btn" aria-label="Iniciar sesión">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-1a7 7 0 0 0-14 0v1"></path><circle cx="13" cy="7" r="4"></circle></svg>
                </a>
            <?php } ?>

            <a href="<?php echo $rutaMenu; ?>carrito.php" class="icono-btn" aria-label="Carrito de compras">
                <svg viewBox="0 0 24 24"><path d="M3 4h2l2.4 12.4a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.6L21 8H6"></path><circle cx="9" cy="21" r="1.4"></circle><circle cx="18" cy="21" r="1.4"></circle></svg>
                <?php if (isset($_SESSION['carrito_cantidad']) && $_SESSION['carrito_cantidad'] > 0) { ?>
                    <span class="badge"><?php echo $_SESSION['carrito_cantidad']; ?></span>
                <?php } ?>
            </a>
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