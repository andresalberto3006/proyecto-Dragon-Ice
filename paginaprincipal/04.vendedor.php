<?php
session_start();
if (!isset($_SESSION['rol'])) { header("Location: ../iniciosesion.php"); exit(); }
if ($_SESSION['rol'] != 'Vendedor') { header("Location: 02.admin.php"); exit(); }
include("../conexion.php");
$ci=$_SESSION['ci'];
$nombreVendedor=$_SESSION['usuario'];
$ventaDia=$conexion->query("SELECT IFNULL(SUM(total),0) AS total FROM ventas WHERE vendedor_ci='$ci' AND fecha=CURDATE()")->fetch_assoc();
$productosDisponibles=$conexion->query("SELECT COUNT(*) AS total FROM productos WHERE stock>0")->fetch_assoc();
$pendientes=$conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE vendedor_ci='$ci' AND estado='Pendiente'")->fetch_assoc();
$proceso=$conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE vendedor_ci='$ci' AND estado='En proceso'")->fetch_assoc();
$historial=$conexion->query("SELECT * FROM ventas WHERE vendedor_ci='$ci' ORDER BY id DESC LIMIT 9");
$stock=$conexion->query("SELECT nombre,stock FROM productos ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Maquetado Semántico</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#020617;
    color:white;
    padding:20px;
    margin: -18px;
}

header, nav, article, section, aside, footer{
    border-radius:10px;
    padding:20px;
    text-align:center
   
}

header{
     background:#0f172a;
    height:80px;
    display: flex;
    flex-direction: row;
    justify-content:space-between;
}
header h1, header button{
    color: azure;
    background: rgb(4, 85, 167);
    border-radius: 10px;
    height: 50px;
    width: 100px;
    border: none;
}
#mio{
    background-color:  #85caec;
    width: 400px;
}
#rex{
    width: 550px;
}
#crack{
    width: 150px
}
nav{
    height:90px;
    display: flex;
    flex-direction: row;
    justify-content:space-between;
}
nav h3:hover{
    transition: 0,9s;
    transform: scale(1.05);
    border: solid 2px rgb(24, 224, 107);
}

main{
    display:flex;
    gap:2px;
}

article{
    flex:2;
    height:800px;
   
}
nav h3{
    background-color: white;
    color: black;
    border-radius: 15px;
    width: 240px;
    height: 50px;
    display: flex;
    align-items: center;
 
}

section{
    margin-top:20px;
    height:630px;
    background:#020617;
    display: flex;
    flex-direction:row;
    justify-content: space-between;
}
section h2{
     background:rgb(7,53,106);
    border-radius: 15px;
    width:370px;
    margin: 10px;
   
}
section h2:hover{
    transition: 0.5s;
    transform: scale(1.05);
    border: solid 2px #0fa945;
}
#ttt{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;
}
 
 form {
    display:flex;
    flex-direction:column;
    gap:15px;
    margin: 30px;
}
input{
    padding:12px;
    border:none;
    border-radius:10px;
    background: white;
    color:black;
}
section button{
    margin: 20px;
    height: 50px;
    border-radius: 15px;
    border: none;
    background:#0fa945;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}
form button:hover{
    transition: 0.5s;
    background-color:#0fa945;
}

aside{
    background:linear-gradient(135deg, rgba(5,112,235,0.32), #2563eb);
    flex:1;
    height:800px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

}
aside button{
    background: #85caec;
    height: 60px;
    border-radius: 15px;
    border: none;
    margin: 30px;
    font-size: 20px;
    color: aliceblue;
}
button:hover{
    background:#1a3e82 ;
    transition: 0.5s;
    transform:scale(1.05);
}
#yyy{
 display: grid;
 padding: 20px;
    grid-template-columns: repeat(1,2fr);
}
#dd{
    background-color: white;
    width:345px;
    display: flex;
    color: black;
    height: 440px;
    justify-content: center;
    border-radius: 15px;
    font-size: 25px;
    margin: -7px 
}
table{
    border: none;
}
@media (max-width: 868px){

    main{
        flex-direction: column;
    }

    aside{
        width: 100%;
        height: auto;
    }

    article{
        width: 100%;
        height: auto;
    }

    nav{
        display: flex;
        flex-direction: column;
        justify-content: end;
        padding: 50px;
        height: auto;
        gap: 10px;
        height:500px ;
    }

    nav h3{
        width: 100%;
        display: flex;

    }

    section{
        flex-direction: column;
        height: 1400px;
        gap: 20px;
    }

    section h2{
        width: 100%;
    }

    #dd{
        width: 100%;
        height: auto;
        font-size: 18px;
    }

    header{
        display: grid;
        height: auto;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: 100%;
        grid-template-areas: 
        "uno tres"
        "dos dos";
        gap: 10px;

    }
    #mio{
        width: auto;
        height: 68px;
        grid-area: uno;

    }
    #rex{
        width: auto;
        grid-area: dos;
        display: flex;
        position: absolute;
        bottom: 90px;
        left: 85px;
    }
    #crack{
        width: auto;
        height: 68px;
        grid-area: tres;
    }
    #yyy{
        height: 550px;
    }
}
</style>
</head>
<body>
<header>
    <h1 id="mio">Sistemas de Ventas</h1>
    <h1 id="rex">Panel del Vendedor</h1>
    <button id="crack" onclick="location.href='../cerrar1.php'">CERRAR SESION</button>
</header>
<main>
    <aside>
        <button onclick="location.href='../ventas.php'">VENTAS</button>
        <button onclick="location.href='../producto/read.all.producto.php'">PRODUCTOS</button>
        <button onclick="location.href='../pedidos.php'">PEDIDOS</button>
        <button onclick="location.href='../ventas.php'">HISTORIAL</button>
    </aside>
    <article>
        <nav>
            <h3>💰 Ventas del día<br>Bs. <?php echo $ventaDia['total']; ?></h3>
            <h3>📦 Productos disponibles<br><?php echo $productosDisponibles['total']; ?></h3>
            <h3>⏳ Pedidos pendientes<br><?php echo $pendientes['total']; ?></h3>
            <h3>🔄 Pedidos en proceso<br><?php echo $proceso['total']; ?></h3>
        </nav>
        <section>
            <h2 id="ttt">Ordena Aquí
                <form action="../nuevo_pedido.php" method="POST">
                    <label>Cliente</label>
                    <input type="text" name="nombre" placeholder="Nombre del cliente" required>
                    <label>Fecha</label>
                    <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                    <label>Estado</label>
                    <input type="text" value="Pendiente" readonly>
                    <label>Vendedor</label>
                    <input type="text" value="<?php echo $nombreVendedor; ?>" readonly>
                    <button type="submit">🛒 Comenzar pedido</button>
                </form>
            </h2>
            <h2 id="yyy">Historial
                <table id="dd" border="4px solid">
                    <tr><th>id Venta</th><th>total</th><th>fecha</th></tr>
                    <?php while($fila=$historial->fetch_assoc()) { ?>
                        <tr><td>#<?php echo $fila['id']; ?></td><td>Bs. <?php echo $fila['total']; ?></td><td><?php echo $fila['fecha']; ?></td></tr>
                    <?php } ?>
                </table>
            </h2>
            <h2 id="yyy">Stock de productos
                <table id="dd">
                    <tr><th>Producto</th><th>Stock</th></tr>
                    <?php while($fila=$stock->fetch_assoc()) { ?>
                        <tr><td><?php echo $fila['nombre']; ?></td><td><?php echo $fila['stock']; ?></td></tr>
                    <?php } ?>
                </table>
            </h2>
        </section>
    </article>
</main>
</body>
</html>