<?php
session_start();
?>
<?php
include("../conexion.php");
$resultado = $conexion->query("SELECT * FROM productos ORDER BY id DESC");

$imagenesSabores = [
    'Café' => 'https://images.unsplash.com/photo-1562790879-dfde82829db0?auto=format&fit=crop&w=800&q=80',
    'Frutilla' => 'https://images.unsplash.com/photo-1497034825429-c343d7c6a68f?auto=format&fit=crop&w=800&q=80',
    'Durazno' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?auto=format&fit=crop&w=800&q=80',
    'Canela' => 'https://images.unsplash.com/photo-1629385701021-fcd568a743e8?auto=format&fit=crop&w=800&q=80',
    'Menta' => 'https://images.unsplash.com/photo-1567206563064-6f60f40a2b57?auto=format&fit=crop&w=800&q=80',
    'Banana Split' => 'https://images.unsplash.com/photo-1570197788417-0e82375c9371?auto=format&fit=crop&w=800&q=80',
];

$imagenesGenericas = [
    'https://images.unsplash.com/photo-1560008581-09826d1de69e?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1629385744299-74b9cf013f52?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1633933358116-a27b902fad35?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1629385697093-57be2cc97fa6?auto=format&fit=crop&w=800&q=80',
];
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
    background-image:url("../imagenesproyecto/1 (21).png");
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

/* ---------- TARJETA CON EFECTO FLIP ---------- */

.productos{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:40px;
}

.card{
    width:100%;
    height:340px;
    perspective:1000px;
}

.card-inner{
    width:100%;
    height:100%;
    position:relative;
    transform-style:preserve-3d;
    transition:transform 0.7s;
}

.card:hover .card-inner{
    transform:rotateY(180deg);
}

.card-front,
.card-back{
    position:absolute;
    width:100%;
    height:100%;
    backface-visibility:hidden;
    border-radius:25px;
    overflow:hidden;
}

.card-front{
    background:rgb(125,197,197);
}

.card-front img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.card-front .nombre-flotante{
    position:absolute;
    bottom:0;
    left:0;
    right:0;
    padding:18px;
    background:linear-gradient(180deg, transparent, rgba(0,0,0,0.75));
    text-align:center;
}

.card-front .nombre-flotante h2{
    font-size:20px;
}

.card-back{
    background:rgb(125,197,197);
    color:white;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:25px;
    transform:rotateY(180deg);
}

.card-back h2{
    margin-bottom:10px;
    font-size:20px;
}

.card-back p{
    font-size:14px;
    line-height:1.5;
    margin-bottom:12px;
    color:#eafafa;
}

.card-back .precio{
    font-size:22px;
    font-weight:bold;
}

.card-back .stock{
    margin-top:6px;
    font-size:13px;
    color:#d5f5f5;
}

/* RESPONSIVE */

@media(max-width:900px){

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
            <?php while ($fila=$resultado->fetch_assoc()) {
                if (isset($imagenesSabores[$fila['nombre']])) {
                    $imagenProducto = $imagenesSabores[$fila['nombre']];
                } else {
                    $imagenProducto = $imagenesGenericas[$fila['id'] % count($imagenesGenericas)];
                }
            ?>
                <div class="card">
                    <div class="card-inner">
                        <div class="card-front">
                            <img src="<?php echo $imagenProducto; ?>" alt="<?php echo $fila['nombre']; ?>">
                            <div class="nombre-flotante">
                                <h2><?php echo $fila['nombre']; ?></h2>
                            </div>
                        </div>
                        <div class="card-back">
                            <h2><?php echo $fila['nombre']; ?></h2>
                            <p><?php echo $fila['descripcion']; ?></p>
                            <div class="precio">Bs. <?php echo $fila['precio']; ?></div>
                            <div class="stock">Stock disponible: <?php echo $fila['stock']; ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="card">
                <div class="card-inner">
                    <div class="card-front"><h2>No hay productos registrados</h2></div>
                </div>
            </div>
        <?php } ?>
    </section>
</div>
<?php include("piedepagina.php"); ?>
</body>
</html>