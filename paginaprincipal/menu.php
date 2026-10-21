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

<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
    --fondo-1: #0b1f22;
    --fondo-2: #123338;
    --fondo-3: #1b4a52;
    --celeste: #63d4f2;
    --menta: #7be0c4;
    --blanco: #ffffff;
    --texto-suave: #c7ddec;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dragonice-nav {
    font-family: 'Inter', Arial, sans-serif;
    width: 100%;
    background: #0e2a4d;
    position: sticky;
    top: 0;
    z-index: 1000;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.dragonice-nav .fila {
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 100px;
    padding: 20px 40px;
    gap: 25px;
}

.dragonice-nav .logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    flex-shrink: 0;
}

.dragonice-nav .logo img {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    object-fit: cover;
}

.dragonice-nav .logo h2 {
    font-family: 'Baloo 2', cursive;
    font-size: 32px;
    font-weight: 700;
    color: var(--celeste);
    white-space: nowrap;
    margin: 0;
}

.dragonice-nav .nav-links {
    display: flex;
    align-items: center;
    list-style: none;
    gap: 28px;
    flex: 1;
    margin-left: 25px;
    margin-bottom: 0;
}

.dragonice-nav .nav-links a {
    text-decoration: none;
    color: var(--texto-suave);
    font-size: 17px;
    font-weight: 600;
    transition: color 0.2s ease;
    white-space: nowrap;
}

.dragonice-nav .nav-links a:hover {
    color: var(--celeste);
}

.dragonice-nav .dropdown-menu {
    background: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.dragonice-nav .dropdown-menu .dropdown-item {
    color: #000000 !important;
    font-size: 15px;
    padding: 10px 14px;
    border-radius: 6px;
}

.dragonice-nav .dropdown-menu .dropdown-item:hover {
    background: #e6f8ff;
    color: #0e2a4d !important;
}

.dragonice-nav .iconos {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.dragonice-nav .icono-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    color: var(--texto-suave);
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
    position: relative;
}

.dragonice-nav .icono-btn svg {
    width: 24px;
    height: 24px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
}

.dragonice-nav .icono-btn:hover {
    background: rgba(255,255,255,0.1);
    color: var(--celeste);
}

.dragonice-nav .icono-btn .badge {
    position: absolute;
    top: -2px;
    right: -2px;
    background: var(--menta);
    color: var(--fondo-1);
    font-size: 11px;
    font-weight: 700;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 3px;
}

.dragonice-nav .sesion-texto {
    font-size: 15px;
    font-weight: 700;
    color: var(--fondo-1);
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 25px;
    background: var(--celeste);
    white-space: nowrap;
    transition: background 0.2s ease;
}

.dragonice-nav .sesion-texto:hover {
    background: var(--menta);
}

.dragonice-nav .btn-menu {
    display: none;
    background: none;
    border: none;
    color: var(--blanco);
    font-size: 32px;
    cursor: pointer;
}

@media (max-width: 1100px) {

    .dragonice-nav .fila {
        padding: 18px 20px;
        gap: 12px;
    }

    .dragonice-nav .logo img {
        width: 48px;
        height: 48px;
    }

    .dragonice-nav .logo h2 {
        font-size: 28px;
    }

    .dragonice-nav .nav-links {
        gap: 16px;
        margin-left: 10px;
    }

    .dragonice-nav .nav-links a {
        font-size: 15px;
    }

    .dragonice-nav .iconos {
        gap: 3px;
    }

    .dragonice-nav .icono-btn {
        width: 40px;
        height: 40px;
    }

    .dragonice-nav .sesion-texto {
        padding: 10px 13px;
        font-size: 13px;
    }
}

@media (max-width: 900px) {

    .dragonice-nav .fila {
        flex-wrap: wrap;
        min-height: 85px;
        padding: 14px 20px;
    }

    .dragonice-nav .btn-menu {
        display: block;
        margin-left: auto;
    }

    .dragonice-nav .nav-links {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        order: 4;
        margin: 12px 0 0 0;
        padding: 15px 0;
        gap: 18px;
    }

    .dragonice-nav .nav-links.active {
        display: flex;
    }

    .dragonice-nav .nav-links a {
        font-size: 17px;
    }

    .dragonice-nav .iconos {
        order: 3;
    }

    .dragonice-nav .logo img {
        width: 45px;
        height: 45px;
    }

    .dragonice-nav .logo h2 {
        font-size: 27px;
    }
}
</style>

<nav class="dragonice-nav">
    <div class="fila">
        <a href="<?php echo $rutaMenu; ?>paginaprincipal/01.inicio.php" class="logo">
            <img src="<?php echo $rutaMenu; ?>imagenesproyecto/logo.png" alt="Logo Dragon Ice">
            <h2>Dragon Ice</h2>
        </a>

       
        <button class="btn-menu" id="btnMenu" aria-label="Abrir menú">
            ☰
        </button>

        <ul class="nav-links" id="navLinks">

            <li>
                <a href="<?php echo $rutaMenu; ?>paginaprincipal/01.inicio.php">Inicio</a>
            </li>

            <li>
                <a href="<?php echo $rutaMenu; ?>paginaprincipal/productos.php">Productos</a>
            </li>

            <li>
                <a href="<?php echo $rutaMenu; ?>paginaprincipal/quienessomos.php">Quiénes somos</a>
            </li>

            <li>
                <a href="<?php echo $rutaMenu; ?>paginaprincipal/contactanos.php">Contactos</a>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Más
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="<?php echo $rutaMenu; ?>comentarios/formulario.php">
                            Comentarios
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="<?php echo $rutaMenu; ?>paginaprincipal/fichaambiental.php">
                            Ficha ambiental
                        </a>
                    </li>
                </ul>
            </li>

        </ul>

        <div class="iconos">

            <a href="https://www.google.com/maps?q=-17.39173143466908,-66.15389959642064"
               target="_blank"
               rel="noopener noreferrer"
               class="icono-btn"
               aria-label="Ubicación">

                <svg viewBox="0 0 24 24">
                    <path d="M12 21s-7-6.4-7-11a7 7 0 0 1 14 0c0 4.6-7 11-7 11z"></path>
                    <circle cx="12" cy="10" r="2.5"></circle>
                </svg>
            </a>

            <?php if (isset($_SESSION['rol'])) { ?>

                <?php if ($_SESSION['rol'] == 'Administrador') { ?>

                    <a href="<?php echo $rutaMenu; ?>paginaprincipal/02.admin.php"
                       class="icono-btn"
                       aria-label="Mi panel">

                        <svg viewBox="0 0 24 24">
                            <path d="M20 21v-1a7 7 0 0 0-14 0v1"></path>
                            <circle cx="13" cy="7" r="4"></circle>
                        </svg>
                    </a>

                <?php } else { ?>

                    <a href="<?php echo $rutaMenu; ?>paginaprincipal/03.vendedor.php"
                       class="icono-btn"
                       aria-label="Mi panel">

                        <svg viewBox="0 0 24 24">
                            <path d="M20 21v-1a7 7 0 0 0-14 0v1"></path>
                            <circle cx="13" cy="7" r="4"></circle>
                        </svg>
                    </a>

                <?php } ?>

                <a href="<?php echo $rutaMenu; ?>iniciarsesion/cerrar1.php"
                   class="sesion-texto">
                    Cerrar sesión
                </a>

            <?php } else { ?>
            
                <a href="<?php echo $rutaMenu; ?>iniciarsesion/iniciosesion.php"
                   class="icono-btn"
                   aria-label="Iniciar sesión">

                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-1a7 7 0 0 0-14 0v1"></path>
                        <circle cx="13" cy="7" r="4"></circle>
                    </svg>
                </a>

            <?php } ?>

            <?php if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Administrador') { ?>

                <a href="<?php echo $rutaMenu; ?>carritoAjaxCliente/index.php"
                   class="icono-btn"
                   aria-label="Carrito de compras">

                    <svg viewBox="0 0 24 24">
                        <path d="M3 4h2l2.4 12.4a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.6L21 8H6"></path>
                        <circle cx="9" cy="21" r="1.4"></circle>
                        <circle cx="18" cy="21" r="1.4"></circle>
                    </svg>

                    <?php if (isset($_SESSION['carrito_cantidad']) && $_SESSION['carrito_cantidad'] > 0) { ?>

                        <span class="badge">
                            <?php echo $_SESSION['carrito_cantidad']; ?>
                        </span>

                    <?php } ?>

                </a>

            <?php } ?>

        </div>

    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
const btnMenu = document.getElementById("btnMenu");
const navLinks = document.getElementById("navLinks");

if (btnMenu && navLinks) {
    btnMenu.addEventListener("click", function() {
        navLinks.classList.toggle("active");
    });
}

document.querySelectorAll("#navLinks a").forEach(function(link) {
    link.addEventListener("click", function() {
        navLinks.classList.remove("active");
    });
});
</script>