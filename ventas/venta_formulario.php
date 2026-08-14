<?php
session_start();
if(!isset($_SESSION['rol'])||$_SESSION['rol']!='Vendedor'){header("Location: ../iniciosesion.php");exit();}
include("../conexion.php");
$id=isset($_GET['id'])?$_GET['id']:0;
$ci=$_SESSION['ci'];
$r=$conexion->query("SELECT p.*,IFNULL(SUM(c.costototal),0) AS total FROM pedidos p LEFT JOIN carrito c ON p.id=c.pedidos_id WHERE p.id='$id' AND p.vendedor_ci='$ci' AND p.estado='En proceso' GROUP BY p.id,p.nombre,p.fecha,p.estado,p.vendedor_ci,p.nombrevendedor,p.metodo_pago");
if($r->num_rows==0){header("Location: ../pedidos.php");exit();}
$p=$r->fetch_assoc();
$rutaMenu="../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Venta</title>
    <style>
        :root{
            --azul-oscuro:#0e2a4d;
            --celeste:#63d4f2;
            --menta:#7be0c4;
            --texto-suave:#d9f6ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-section{
            position:relative;
            width:100%;
            min-height:100vh;
            overflow:hidden;
        }

        .auth-section video{
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            width:100%;
            height:100%;
            object-fit:cover;
            z-index:0;
        }

        .auth-section .overlay{
            position:absolute;
            inset:0;
            background:rgba(14,42,77,0.55);
            z-index:1;
        }

        .auth-section main{
            position:relative;
            z-index:2;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:40px 20px;
        }

        .form-box{
            width:100%;
            max-width:430px;
            padding:40px;
            background:rgba(0,0,0,0.55);
            backdrop-filter:blur(12px);
            border-radius:20px;
            border:1px solid rgba(255,255,255,0.2);
            box-shadow:0 0 30px rgba(99,212,242,0.35);
            text-align:center;
        }

        .form-box h1{
            color:white;
            font-size:34px;
            letter-spacing:3px;
            margin-bottom:8px;
            text-shadow:0 0 15px var(--celeste);
        }

        .form-box .subtitulo{
            color:var(--texto-suave);
            margin-bottom:25px;
            font-size:15px;
        }

        .form-box form{
            text-align:left;
        }

        .form-box label{
            display:block;
            text-align:left;
            color:white;
            margin-bottom:5px;
            margin-top:15px;
            font-weight:bold;
            font-size:14px;
        }

        .form-box input,
        .form-box select{
            width:100%;
            padding:12px;
            border:none;
            border-radius:10px;
            outline:none;
            background:rgba(255,255,255,0.15);
            color:white;
            font-size:15px;
        }

        .form-box input::placeholder{
            color:rgba(255,255,255,0.65);
        }

        .form-box input:focus,
        .form-box select:focus{
            background:rgba(255,255,255,0.25);
            box-shadow:0 0 0 2px var(--celeste);
        }

        .form-box input[type="submit"],
        .form-box button[type="submit"]{
            width:100%;
            margin-top:22px;
            padding:13px;
            border:none;
            border-radius:10px;
            background:var(--celeste);
            color:var(--azul-oscuro);
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .form-box input[type="submit"]:hover,
        .form-box button[type="submit"]:hover{
            background:var(--menta);
            transform:scale(1.02);
        }

        .form-box .enlace-secundario{
            margin-top:18px;
            font-size:14px;
            color:var(--texto-suave);
            text-align:center;
        }

        .form-box .enlace-secundario a{
            color:var(--celeste);
            font-weight:bold;
            text-decoration:none;
        }

        .form-box .enlace-secundario a:hover{
            text-decoration:underline;
            color:var(--menta);
        }

        .form-box .volver{
            display:block;
            margin-top:10px;
            color:white;
            font-size:13px;
            opacity:0.8;
            text-decoration:none;
            text-align:center;
        }

        .form-box .volver:hover{
            opacity:1;
            color:var(--celeste);
        }

        .form-box label.error{
            color:#ff9b9b;
            font-size:12px;
            margin-top:4px;
            margin-bottom:0;
            font-weight:bold;
        }

        .form-box input.error{
            box-shadow:0 0 0 2px #ff4d4d;
        }

        .form-box input.valid{
            box-shadow:0 0 0 2px var(--menta);
        }

        @media(max-width:700px){
            .form-box{ padding:28px; }
            .form-box h1{ font-size:26px; }
        }
    </style>
</head>
<body>
    <?php include("../menu.php"); ?>

    <section class="auth-section">
        <video autoplay muted loop>
            <source src="../helado1.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <main>
            <div class="form-box">
                <h1>DRAGON ICE</h1>
                <p class="subtitulo">Registrar Venta</p>

                <form action="registrarVenta.php" method="POST">
                    <input type="hidden" name="idPedido" value="<?php echo $p['id'];?>">
                    <label>Cliente</label>
                    <input type="text" value="<?php echo $p['nombre'];?>" readonly>
                    <label>Total</label>
                    <input type="text" value="Bs. <?php echo $p['total'];?>" readonly>
                    <label>Método de pago</label>
                    <input type="text" name="metodo_pago" placeholder="Efectivo o transferencia" required>
                    <input type="submit" value="Guardar venta">
                </form>

                <a href="../pedidos/pedidos.php" class="volver">Volver a pedidos</a>
            </div>
        </main>
    </section>

    <?php include("../paginaprincipal/piedepagina.php"); ?>
</body>
</html>