<?php
if (session_status() == PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}
if (!isset($rutaMenu)) {
    $rutaMenu = "";
}
?>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

.menu{
    width:100%;
    background:#79ecf0e6;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    border-bottom:2px solid white;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
}

.logo img{
    width:50px;
    height:50px;
    object-fit:contain;
}

.logo h2{
    color:white;
    font-size:32px;
    text-shadow:1px 1px 3px rgba(0,0,0,0.4);
}

.nav-links{
    display:flex;
    list-style:none;
    gap:30px;
}

.nav-links a{
    text-decoration:none;
    color:white;
    font-size:20px;
    font-weight:bold;
    transition:0.3s;
}

.nav-links a:hover{
    color:#dbeafe;
}

.btn-menu{
    display:none;
    background:none;
    border:none;
    color:white;
    font-size:2rem;
    cursor:pointer;
}

@media(max-width:768px){

    .btn-menu{
        display:block;
    }

    .nav-links{
        display:none;
        flex-direction:column;
        position:absolute;
        top:80px;
        left:0;
        width:100%;
        background:#5a90e7;
        text-align:center;
        padding:20px 0;
        gap:15px;
    }

    .nav-links.active{
        display:flex;
    }
}
</style>

<nav class="menu">
    <div class="logo">
        <img src="<?php echo $rutaMenu; ?>imagenesproyecto/logo.png" alt="logo">
        <h2>Dragon Ice</h2>
    </div>
    <button class="btn-menu" id="btnMenu">☰</button>
    <ul class="nav-links" id="navLinks">
        <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/01.inicio.php">Inicio</a></li>
        <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/productos.php">Productos</a></li>
        <li><a href="<?php echo $rutaMenu; ?>quienessomos.php">Quiénes somos</a></li>
        <?php if (isset($_SESSION['rol'])) { ?>
            <?php if ($_SESSION['rol'] == 'Administrador') { ?>
                <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/02.admin.php">Mi panel</a></li>
            <?php } else { ?>
                <li><a href="<?php echo $rutaMenu; ?>paginaprincipal/04.vendedor.php">Mi panel</a></li>
            <?php } ?>
            <li><a href="<?php echo $rutaMenu; ?>cerrar1.php">Cerrar sesión</a></li>
        <?php } else { ?>
            <li><a href="<?php echo $rutaMenu; ?>iniciosesion.php">Iniciar sesión</a></li>
        <?php } ?>
    </ul>
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