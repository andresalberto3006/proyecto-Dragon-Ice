<?php
session_start();
?>
<?php
include("../conexion.php");
$resultado = $conexion->query("SELECT * FROM productos ORDER BY id DESC");

$imagenesSabores = [
   
    1  => '../imagenesproyecto/banana.jpg',
    2  => '../imagenesproyecto/blue.jpg',
    3  => '../imagenesproyecto/bolos.jpg',
    4  => '../imagenesproyecto/boobas.jpg',
    5  => '../imagenesproyecto/brownie.jpg',
    6  => '../imagenesproyecto/combo.jpg',
    7  => '../imagenesproyecto/conos.jpg',
    8  => '../imagenesproyecto/ensalada.jpg',
    9  => '../imagenesproyecto/kiyrbi.jpg',
    10 => '../imagenesproyecto/mochi.jpg',
    12 => '../imagenesproyecto/pez.jpg',
    13 => '../imagenesproyecto/picante.jpg',
    14 => '../imagenesproyecto/raspados.jpg',
    15 => '../imagenesproyecto/relleno.jpg',
    16 => '../imagenesproyecto/rollo.jpg',
    17 => '../imagenesproyecto/rollocanela.jpg',
    18 => '../imagenesproyecto/snoopye.jpg',
    19 => '../imagenesproyecto/tacos.jpg',
    20 => '../imagenesproyecto/Chocolate1.jpg',
    21 => '../imagenesproyecto/Coco1.jpg',
    22 => '../imagenesproyecto/Canela1.jpg',
    23 => '../imagenesproyecto/Durazno1.jpg',
    24 => '../imagenesproyecto/Frutilla1.jpg',
    25 => '../imagenesproyecto/Limon1.jpg',
    26 => '../imagenesproyecto/Mango1.jpg',
    27 => '../imagenesproyecto/Menta1.jpg',
    28 => '../imagenesproyecto/Piña1.jpg',
    29 => '../imagenesproyecto/Vainilla1.jpg',
    30 => '../imagenesproyecto/Frutilla2.jpg',
    31 => '../imagenesproyecto/Leche2.jpg',
    32 => '../imagenesproyecto/Maracuya2.jpg',
    33 => '../imagenesproyecto/Vainilla2.jpg',
    34 => '../imagenesproyecto/Chocolate2.jpg',
    35 => '../imagenesproyecto/Oreo2.jpg',
    36 => '../imagenesproyecto/Chicle2.jpg',
    37 => '../imagenesproyecto/Cafe2.jpg',
    38 => '../imagenesproyecto/Coco2.jpg',
    39 => '../imagenesproyecto/Mango2.jpg',
    
];

$imagenGenerica = '../imagenesproyecto/logo.png';


$categoriasSabores = [
    1  => 'especiales',
    2  => 'especiales',
    3  => 'especiales',
    4  => 'especiales',
    5  => 'especiales',
    6  => 'especiales',
    7  => 'especiales',
    8  => 'especiales',
    9  => 'especiales',
    10 => 'especiales',
    11 => 'especiales',
    12 => 'especiales',
    13 => 'especiales',
    14 => 'especiales',
    15 => 'especiales',
    16 => 'especiales',
    17 => 'especiales',
    18 => 'especiales',
    19 => 'especiales',
    20 => 'paletas',
    21 => 'paletas',
    22 => 'paletas',
    23 => 'paletas',
    24 => 'paletas',
    25 => 'paletas',
    26 => 'paletas',
    27 => 'paletas',
    28 => 'paletas',
    29 => 'paletas',
    30 => 'bolos',
    31 => 'bolos',
    32 => 'bolos',
    33 => 'bolos',
    34 => 'bolos',
    35 => 'bolos',
    36 => 'bolos',
    37 => 'bolos',
    38 => 'bolos',
    39 => 'bolos',

];

$categoriasDisponibles = ['paletas','bolos','especiales'];
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
    background:#ffffff;
    color:#0e2a4d;
}


.contenedor{
    width:90%;
    margin:auto;
    padding:50px 0;
}

.titulo{
    text-align:center;
    margin-bottom:40px;
}

.titulo h1{
    font-size:42px;
    font-weight:700;
    color:#0e2a4d;
}

.titulo p{
    margin-top:10px;
    font-size:16px;
    color:#5b7590;
}


.filtros{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:12px;
    margin-bottom:45px;
}

.filtros button{
    font-family: Arial, Helvetica, sans-serif;
    border:2px solid #63d4f2;
    background:#ffffff;
    color:#0e2a4d;
    font-size:14px;
    font-weight:700;
    padding:10px 24px;
    border-radius:40px;
    cursor:pointer;
    transition:.25s;
}

.filtros button:hover{
    background:#63d4f2;
}

.filtros button.activo{
    background:#0e2a4d;
    border-color:#0e2a4d;
    color:#ffffff;
}



.productos{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:45px;
    padding-bottom:40px;
}

.card.oculta{
    display:none;
}



.card{
    width: 220px;
    height: 500px;
    border-radius: 1.2em;
    padding: 2rem;
    position: relative;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    transition: 0.4s ease-out;
    box-shadow: 0px 7px 20px rgba(14, 42, 77, 0.2);
}

.card-img{
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-size: cover;
    background-position: center;
}

.card:before{
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(14, 42, 77, 0.75);
    opacity: 0;
    transition: 0.4s;
}

.card-info{
    position: relative;
    z-index: 2;
    color: #ffffff;
    opacity: 0;
    transform: translateY(20%);
    transition: 0.4s;
    width: 100%;
    background: rgba(3, 182, 253, 0.69);
    border-radius: 12px;
    padding: 14px 16px;
    backdrop-filter: blur(3px);
}

.card-info .text-title{
    font-size: 1.6rem;
    font-weight: 700;
    text-shadow: 0 1px 4px rgba(0,0,0,0.6);
}

.card-info .text-body{
    font-size: 1rem;
    margin: 10px 0 2px 0;
    line-height:1.4;
    color: #ffffff;
}

.card:hover{
    transform: translateY(-5px);
}

.card:hover:before{
    opacity: 1;
}

.card:hover .card-info{
    opacity: 1;
    transform: translateY(0);
}

</style>
</head>
<body>
<header class="menu-principal">
<?php $rutaMenu="../"; include("../paginaprincipal/menu.php"); ?>
</header>
<div class="contenedor">
    <header class="titulo">
        <h1>Nuestros Sabores</h1>
        <p>Descubre la cremosidad artesanal en cada cucharada</p>
    </header>
    <div class="filtros">
        <button class="activo" data-filtro="todos">Todos</button>
        <button data-filtro="paletas">Paletas</button>
        <button data-filtro="bolos">Bolos</button>
        <button data-filtro="especiales">Especiales</button>
    </div>

    <section class="productos" id="listaProductos">
        <?php if ($resultado->num_rows > 0) { ?>
            <?php while ($fila=$resultado->fetch_assoc()) {
              if (!empty($fila['imagen'])) {
                    $imagenProducto = "../" . $fila['imagen'];
                } else {
                    $imagenProducto = $imagenGenerica;
                }
                if (isset($categoriasSabores[$fila['id']])) {
                    $categoriaProducto = $categoriasSabores[$fila['id']];
                } else {
                    $categoriaProducto = $categoriasDisponibles[$fila['id'] % count($categoriasDisponibles)];
                }
            ?>
                <div class="card" data-categoria="<?php echo $categoriaProducto; ?>">
                    <div class="card-img" style="background-image:url('<?php echo $imagenProducto; ?>')"></div>
                    <div class="card-info">
                        <p class="text-title"><?php echo $fila['nombre']; ?></p>
                        <p class="text-body"><?php echo $fila['descripcion']; ?></p>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No hay productos registrados.</p>
        <?php } ?>
    </section>
</div>
<?php include("piedepagina.php"); ?>
<script>
$(document).ready(function(){
    $(".filtros button").on("click", function(){
        var filtro = $(this).data("filtro");

        $(".filtros button").removeClass("activo");
        $(this).addClass("activo");

        if(filtro === "todos"){
            $(".card").removeClass("oculta");
        } else {
            $(".card").each(function(){
                if($(this).data("categoria") === filtro){
                    $(this).removeClass("oculta");
                } else {
                    $(this).addClass("oculta");
                }
            });
        }
    });
});
</script>
</body>
</html>