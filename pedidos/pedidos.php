<?php
session_start();if(!isset($_SESSION['rol'])){header("Location: ../iniciosesion.php");exit();}include("../conexion.php");
if($_SESSION['rol']=='Administrador'){$resultado=$conexion->query("SELECT p.*,IFNULL(SUM(c.costototal),0) AS total FROM pedidos p LEFT JOIN carrito c ON p.id=c.pedidos_id GROUP BY p.id,p.nombre,p.fecha,p.estado,p.vendedor_ci,p.nombrevendedor,p.metodo_pago ORDER BY p.id DESC");}else{$ci=$_SESSION['ci'];$resultado=$conexion->query("SELECT p.*,IFNULL(SUM(c.costototal),0) AS total FROM pedidos p LEFT JOIN carrito c ON p.id=c.pedidos_id WHERE p.vendedor_ci='$ci' OR (p.vendedor_ci IS NULL AND p.estado='Pendiente') GROUP BY p.id,p.nombre,p.fecha,p.estado,p.vendedor_ci,p.nombrevendedor,p.metodo_pago ORDER BY p.id DESC");}
$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pedidos</title>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

html, body{
    height:100%;
}
body{
    display:flex;
    flex-direction:column;
    min-height:100vh;
}
.fondo-panel{
    flex:1;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:40px;
    display:flex;
    justify-content:center;
    align-items:flex-start;
}
.contenedor{

    width:100%;
    max-width:1200px;

    background:white;

    padding:30px;

    border-radius:25px;

    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

h1{
    text-align:center;
    color:#18335c;
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
}

th{
    background:#4da6ff;
    color:white;
    padding:15px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f4f8ff;
}

.boton{

    text-decoration:none;

    color:white;

    padding:8px 15px;

    border-radius:8px;

    font-size:14px;

    font-weight:bold;
}

.mostrar{
    background:#4da6ff;
}

.editar{
    background:#28a745;
}

.eliminar{
    background:#dc3545;
}

.acciones{
    display:flex;
    justify-content:center;
    gap:8px;
    flex-wrap:wrap;
}

.volver{
    display:block;
    width:250px;
    margin:30px auto 0;
    text-align:center;
    text-decoration:none;
    background:#18335c;
    color:white;
    padding:15px;
    border-radius:10px;
    font-weight:bold;
}

.volver:hover{
    background:#2f5d9f;
}

@media(max-width:1024px){

    .fondo-panel{
        padding:30px 20px;
    }

    .contenedor{
        padding:25px 20px;
    }

    th, td{
        padding:10px 8px;
        font-size:14px;
    }

    .boton{
        padding:7px 10px;
        font-size:13px;
    }
}


@media(max-width:768px){

    .fondo-panel{
        padding:20px 12px;
    }

    .contenedor{
        padding:20px 15px;
        border-radius:18px;
    }

    h1{
        font-size:22px;
        margin-bottom:20px;
    }

    table, tbody, tr, td{
        display:block;
        width:100%;
    }

    thead{
        display:none;
    }

    tr{
        border:1px solid #dbe6f5;
        border-radius:14px;
        margin-bottom:15px;
        padding:6px 14px;
        background:white;
        box-shadow:0 3px 10px rgba(0,0,0,0.08);
    }

    td{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:15px;
        text-align:right;
        padding:10px 0;
        border-bottom:1px solid #eef2f8;
    }

    td:last-child{
        border-bottom:none;
    }

    td::before{
        content:attr(data-label);
        font-weight:bold;
        color:#18335c;
        text-align:left;
        flex-shrink:0;
    }

    td.celda-acciones{
        flex-direction:column;
        align-items:stretch;
        text-align:center;
    }

    td.celda-acciones::before{
        text-align:left;
        margin-bottom:8px;
    }

    .acciones{
        justify-content:stretch;
    }

    .acciones .boton{
        flex:1 1 auto;
        text-align:center;
        padding:10px;
    }

    td.vacio{
        display:block;
        text-align:center;
    }

    td.vacio::before{
        display:none;
    }

    .volver{
        width:100%;
    }
}

@media(max-width:480px){

    .fondo-panel{
        padding:15px 8px;
    }

    .contenedor{
        padding:15px 10px;
    }

    h1{
        font-size:19px;
    }

    tr{
        padding:4px 10px;
    }

    td{
        font-size:13px;
    }

    .acciones{
        flex-direction:column;
    }

    .acciones .boton{
        flex:none;
        width:100%;
    }

    .volver{
        padding:13px;
        font-size:14px;
    }
}

</style>
</head>
<body>
    <?php include("../paginaprincipal/menu.php"); ?>

    <main class="fondo-panel">
      <div class="contenedor">
        <h1> Lista de Pedidos</h1>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if($resultado->num_rows>0){while($fila=$resultado->fetch_assoc()){?>
            <tr>
                <td data-label="ID">
                    <?php echo $fila['id'];?>
                </td>
                <td data-label="Cliente">
                    <?php echo $fila['nombre'];?>
                </td>
                <td data-label="Fecha">
                    <?php echo $fila['fecha'];?>
                </td>
                <td data-label="Estado">
                    <?php echo $fila['estado'];?>
                </td>
                <td data-label="Vendedor">
                    <?php echo $fila['nombrevendedor'];?>
                </td>
                <td data-label="Total">
                    Bs. <?php echo $fila['total'];?>
                </td>
                <td class="celda-acciones" data-label="Acciones">
                    <div class="acciones">
                        <a class="boton mostrar" href="detallePedido.php?id=<?php echo $fila['id'];?>">Detalle</a>
                        <?php if($_SESSION['rol']=='Vendedor'&&$fila['estado']=='Pendiente'){?>
                            <a class="boton editar" href="../pedidos/cambiarEstadoPedido.php?id=<?php echo $fila['id'];?>&estado=En proceso">Aceptar</a>
                            <a class="boton eliminar" href="cambiarEstadoPedido.php?id=<?php echo $fila['id'];?>&estado=Rechazado">Rechazar</a>
                        <?php }?>
                        <?php if($_SESSION['rol']=='Vendedor'&&$fila['estado']=='En proceso'){?>
                            <a class="boton editar" href="../ventas/venta_formulario.php?id=<?php echo $fila['id'];?>">Registrar venta</a>
                        <?php }?>
                        <?php if($fila['estado']=='Rechazado'&&($_SESSION['rol']=='Vendedor'||$_SESSION['rol']=='Administrador')){?>
                            <a class="boton eliminar" href="eliminarPedido.php?id=<?php echo $fila['id'];?>">Eliminar</a>
                        <?php }?>
                    </div>
                </td>
            </tr>
            <?php }}else{?>
            <tr>
                <td class="vacio" colspan="7">No hay pedidos registrados.</td>
            </tr>
            <?php }?>
            </tbody>
        </table>
        <?php if($_SESSION['rol']=='Vendedor'){?>
            <a href="../paginaprincipal/03.vendedor.php" class="volver">Volver al panel</a>
        <?php }else{?>
            <a href="../paginaprincipal/02.admin.php" class="volver">Volver al panel</a>
        <?php }?>
        </div>
     </main>
      <?php include("../paginaprincipal/piedepagina.php"); ?>
    
</body>
</html>