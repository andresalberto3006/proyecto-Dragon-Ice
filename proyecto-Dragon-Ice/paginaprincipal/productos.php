<?php
session_start();
?>
<?php
include("../conexion.php");
$resultado = $conexion->query("SELECT * FROM productos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<title>Dragon Ice</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: Arial, Helvetica, sans-serif;
    background-image:url("1 (4).png");
    background-size:cover;
    background-attachment:fixed;
    background-position:center;
    background-color:rgb(10,10,70);
    color:white;
}

/* EFECTOS DE FONDO */

body::before{
    content:"";
    position:fixed;
    width:500px;
    height:500px;
    background:rgba(255,255,255,0.08);
    border-radius:50%;
    top:-150px;
    right:-100px;
    filter:blur(40px);
    z-index:-1;
}

body::after{
    content:"";
    position:fixed;
    width:400px;
    height:400px;
    background:rgba(0,255,255,0.1);
    border-radius:50%;
    bottom:-120px;
    left:-100px;
    filter:blur(50px);
    z-index:-1;
}

/* MENU */



article{
    position:relative;
}

article ul{
    position:absolute;
    top:40px;
    left:0;
    background:white;
    border-radius:10px;
    min-width:180px;
    display:none;

    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.3);

}

article:hover ul{
    display:block;
    transform: scale(1.25);

}

article li{
    list-style:none;
}

article li a{
    display:block;
    padding:12px;
    color:black;
    text-decoration:none;
}

article li a:hover{
    background:#f0f0f0;
}

/* CONTENIDO */

.contenedor{
    width:90%;
    margin:auto;
    padding:40px 0;
}

.titulo{
    text-align:center;
    margin-bottom:60px;
}

.titulo h1{
    font-size:70px;
    background-color:rgb(125,197,197);
    border-radius:25px;
    padding:20px;
    display:inline-block;
}

.titulo p{
    margin-top:15px;
    font-size:22px;
}

/* PRODUCTOS */

.productos{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:35px;
}

.card{
    background:rgb(125,197,197);
    border-radius:25px;
    overflow:hidden;
    transition:.4s;
}

.card:hover{
    transform:scale(1.03);
}

.card img{
    width:100%;
    height:280px;
    object-fit:cover;
}

.info{
    padding:25px;
    text-align:center;
}

.info h2{
    margin-bottom:10px;
}

/* CONTACTO */

.contacto{
    margin-top:80px;
    background:rgb(125,197,197);
    border-radius:30px;
    padding:40px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
}

iframe{
    width:100%;
    height:350px;
    border:none;
    border-radius:20px;
}

/* RESPONSIVE */

@media(max-width:900px){

    .menu-principal{
        flex-direction:column;
    }

    .contacto{
        grid-template-columns:1fr;
    }

    .titulo h1{
        font-size:45px;
    }
}

@media(max-width:600px){

    .titulo h1{
        font-size:35px;
    }

    .titulo p{
        font-size:18px;
    }
}

</style>
</head>

<body>

<header class="menu-principal">
<?php $rutaMenu="../"; include("../menu.php"); ?>
</header>
<div class="contenedor">
    <header class="titulo">
        <h1>PRODUCTOS 🍦</h1>
        <p>Los sabores más refrescantes y deliciosos</p>
    </header>
    <section class="productos">
        <?php if ($resultado->num_rows > 0) { ?>
            <?php while ($fila=$resultado->fetch_assoc()) { ?>
                <div class="card">
                    <img src="../<?php echo $fila['imagen']; ?>" alt="">
                    <div class="info">
                        <h2><?php echo $fila['nombre']; ?></h2>
                        <p><?php echo $fila['descripcion']; ?></p>
                        <p>Precio: Bs. <?php echo $fila['precio']; ?></p>
                        <p>Stock disponible: <?php echo $fila['stock']; ?></p>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="card"><div class="info"><h2>No hay productos registrados</h2></div></div>
        <?php } ?>
    </section>
    <?php include("piedepagina.php"); ?>
</div>
</body>
</html>
