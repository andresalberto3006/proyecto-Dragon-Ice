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
        padding: 20px;
    }
    header, nav, aside, article, section, footer{
        border: solid 3px white;
        padding: 20px;
        border-radius: 15px;
        text-align: center;
    }
    header{
        background-color: rgb(27, 97, 129);
        height: 60px;
        display: flex;
        justify-content: space-between;
    }
    header h2{
        background-color: greenyellow;
        width: 80px;
        height: 30px;
        border-radius: 15px;
    }
       aside{
        flex: 1;
        background-color: aqua;
        height:850px ;
}

body{
    background:#020617;
    color:white;
    padding:20px;
    margin: -18px;
}

header, nav, article, section, aside, footer{
    border:2px solid  rgb(118,158,203);
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
    width: 600px;
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

main{
    display:flex;
    gap:2px;
}

article{
    flex:2;
    height:800px;
    
}
nav h3{
    color: black;
    background-color: rgb(91, 187, 238);
    border-radius: 15px;
    width: 240px;
    height: 50px;
    display: flex;
    align-items: center;
  
}

section{
    margin-top:20px;
    height:470px;
    background:#020617;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
section h2{
     background:rgb(7,53,106);
    border-radius: 15px;
    width:370px;
    margin: 10px;    
}
section h2:hover{
    transition: 0.6s;
    transform: scale(1.05);
}
img{
      width: 100%;
    max-width: 300px;
    height: auto;
    display: block;
    margin: 20px auto;
    object-fit: contain;
}
#ttt{
    border-radius: 10px;
    height: 50px;
    width: auto;
    background: #85caec;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin: 20px;
    text-decoration: none;
    color: black;
    padding: 10px;
}

#ttt:hover{
    background:#cdecf6 ;
    transition: 0.5s;
    transform:scale(1.05);
    border: 2px solid #f21212;
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
    height: 70px;
    border-radius: 15px;
    border: none;
    margin: 30px;
    font-size: 20px;
    color: aliceblue;
}
button:hover{
    background:#036e92 ;
    transition: 0.5s;
    transform:scale(1.05);
    border: 2px solid #ffffff;
}

footer{
    background-color: gray;
    height:auto;
}
table{
    background-color: white;
     width:100%;
    color: black;
     border-radius:20px;
     border-collapse:collapse;
    overflow:hidden;
     box-shadow:0 4px 10px rgba(0,0,0,0.2);
}
@media (max-width: 668px){

    main{
        flex-direction: column;
    }

    aside{
        width: 100%;
        height: auto;
    }

    header{
        flex-direction: column;
        height: auto;
        gap: 10px;
    }

    #mio{
        width: 100%;
    }

    #rex{
        width: 100%;
    }

    #crack{
        width: 100%;
    }

    nav{
        flex-direction: column;
        height: auto;
        gap: 10px;
    }

    nav h3{
        width: 100%;
    }

    section{
        flex-direction: column;
        height: auto;
        gap: 20px;
    }
    section h3{
        background: gray;
        border-radius: 15px;
        width: 450px;
    }    
    footer{
        background-color: beige;
    }
header{
    grid-area:uno;
    background:#0f172a;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:3px solid rgb(118,158,203);
    gap: 25;
}

    section h2{
        width: 100%;
    }

    img{
        max-width: 100%;
    }

    footer{
        overflow-x: auto;
    }

    table{
        min-width: 700px;
    }
}
</style>
</head>
<body>
<?php session_start();?>
<header>
    <h1 id="mio">Sistemas del administrador</h1>
    <h1 id="rex">Panel del administrador</h1>
    <button id="crack"><a href="iniciosesion.php">CERRAR SESION<?php echo $_SESSION['usuario'].$_SESSION['apellido']?></a> </button>
</header>

 
<main>

    <aside>
        <button>Gestionar usuario</button>
        <button>Gestionar Productos</button>
        <button>Visualizar reportes del sistemas</button>
        <button>Supervizar ventas y pedidos</button>
    </aside>
    <article>
        <nav>
          <h3>Total de usuarios</h3>
       <h3>Total de productos</h3>
       <h3>Ventas del dia</h3>
       <h3>Ventas del dia</h3>
        </nav>
        <section>
            <h2>Resumen de Ventas
             <img src="./imagenesproyecto/graficotr1.png" alt="">   
            </h2>
            <h2>Ventas por categoria
                <img src="./imagenesproyecto/grafico tr2.png" alt="">
            </h2>
            <h2>Productos mas vendidos
                <a id="ttt" href="">Crear usuario</a>
                <a id="ttt" href="">Registrar producto</a>
                <a id="ttt" href="">Ver todas las ventas</a>
                <a id="ttt" href="">Generar reporte</a>
            </h2>
        </section>
        
    
</body>
</html>


