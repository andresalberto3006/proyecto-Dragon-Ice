<?php
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
        <img src="logo.png" alt="Logo">
        <h2>Dragon Ice</h2>
    </div>

    <button class="btn-menu" id="btnMenu">
        ☰
    </button>

    <ul class="nav-links" id="navLinks">
        <li><a href="01.inicio.php">Inicio</a></li>
        <li><a href="08.formulariousuario.php">Registrarte</a></li>
        <li><a href="login.php">Iniciar Sesión</a></li>
    </ul>

</nav>

<script>
const btnMenu = document.getElementById("btnMenu");
const navLinks = document.getElementById("navLinks");

btnMenu.addEventListener("click", function(){
    navLinks.classList.toggle("active");
});
</script>