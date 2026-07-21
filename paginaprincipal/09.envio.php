<?php
header("Location: 01.inicio.php");
exit();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gracias por tu compra</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    background:
    radial-gradient(circle at top left,#1e4b8f 0%,transparent 30%),
    radial-gradient(circle at bottom right,#0f6fff 0%,transparent 30%),
    linear-gradient(135deg,#061428,#0a2342,#102f5e);
}

.burbuja{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.05);
    animation:flotar 10s infinite linear;
}

.b1{
    width:200px;
    height:200px;
    top:10%;
    left:5%;
}

.b2{
    width:300px;
    height:300px;
    bottom:-50px;
    right:-50px;
}

@keyframes flotar{
    0%{transform:translateY(0);}
    50%{transform:translateY(-20px);}
    100%{transform:translateY(0);}
}

.contenedor{
    width:90%;
    max-width:850px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border:1px solid rgba(255,255,255,0.15);
    border-radius:30px;
    padding:50px;
    text-align:center;
    color:white;
    box-shadow:0 20px 50px rgba(0,0,0,0.4);
    position:relative;
}

.check{
    width:120px;
    height:120px;
    margin:auto;
    border-radius:50%;
    background:linear-gradient(135deg,#00d26a,#00a651);
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:60px;
    box-shadow:0 0 30px rgba(0,210,106,0.5);
    animation:zoom 1s ease;
}

@keyframes zoom{
    from{
        transform:scale(0);
    }
    to{
        transform:scale(1);
    }
}



.subtitulo{
    margin-top:15px;
    font-size:20px;
    color:#d9e8ff;
    line-height:1.8;
}

.tarjetas{
    display:flex;
    gap:20px;
    justify-content:center;
    flex-wrap:wrap;
    margin-top:40px;
}

.tarjeta{
    background:rgba(255,255,255,0.07);
    padding:25px;
    border-radius:20px;
    width:220px;
    transition:.3s;
}

.tarjeta:hover{
    transform:translateY(-8px);
    background:rgba(255,255,255,0.12);
}

.tarjeta h3{
    color:#7ec8ff;
    margin-bottom:10px;
}

.tarjeta p{
    font-size:14px;
    color:#d9e8ff;
}

.botones{
    margin-top:40px;
}

.btn{
    text-decoration:none;
    display:inline-block;
    margin:10px;
    padding:15px 30px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;
}

.btn-principal{
    background:linear-gradient(135deg,#0f6fff,#4aa3ff);
    color:white;
}

.btn-principal:hover{
    transform:scale(1.05);
}

.btn-secundario{
    border:2px solid #4aa3ff;
    color:#4aa3ff;
}

.btn-secundario:hover{
    background:#4aa3ff;
    color:white;
}

.pie{
    margin-top:30px;
    color:#b9d4ff;
    font-size:14px;
}

@media(max-width:768px){
    h1{
        font-size:38px;
    }

    .contenedor{
        padding:30px;
    }
}
</style>
</head>
<body>

<div class="burbuja b1"></div>
<div class="burbuja b2"></div>

<div class="contenedor">

    <div class="check">✓</div>

    <h1>¡Gracias por tu compra!</h1>

    <p class="subtitulo">
        Tu pedido ha sido registrado exitosamente.
        Nuestro equipo ya está preparando todo para que recibas tu compra
        lo antes posible.
    </p>

    <div class="tarjetas">

        <div class="tarjeta">
            <h3>📦 Pedido Confirmado</h3>
            <p>Hemos recibido correctamente tu solicitud de compra.</p>
        </div>

        <div class="tarjeta">
            <h3>🚚 En Preparación</h3>
            <p>Tu pedido será procesado y enviado en breve.</p>
        </div>

        <div class="tarjeta">
            <h3>💳 Pago Verificado</h3>
            <p>La transacción se realizó de manera segura.</p>
        </div>

    </div>

    <div class="botones">
        <a href="formulariopedido.php" class="btn btn-principal">Seguir Comprando</a>
        <a href="formulariocarrito.php" class="btn btn-secundario">Ver Mis Pedidos</a>
    </div>

    <div class="pie">
        Gracias por confiar en nosotros. Esperamos verte nuevamente muy pronto.
    </div>

</div>

</body>
</html>