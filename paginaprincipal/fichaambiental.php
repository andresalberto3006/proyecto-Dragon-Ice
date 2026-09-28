<?php
session_start();
$rutaMenu = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ficha Ambiental | Dragon Ice</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    display:flex;
    flex-direction:column;
    min-height:100vh;
}

.fondo-panel{
    flex:1;
    background:linear-gradient(135deg,#18335c,#2f5d9f,#7fc7ff);
    padding:30px 20px;
    display:flex;
    justify-content:center;
    align-items:flex-start;
}

.visor{
    width:100%;
    max-width:900px;
    display:flex;
    flex-direction:column;
    gap:20px;
}

.visor canvas{
    display:block;
    width:100%;
    height:auto;
    background:white;
    border-radius:8px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}

.cargando{
    text-align:center;
    color:white;
    padding:40px;
    font-size:18px;
}

</style>
</head>
<body>

<?php include("menu.php"); ?>

<main class="fondo-panel">
    <div class="visor" id="visor">
        <div class="cargando" id="cargando">Cargando ficha ambiental...</div>
    </div>
</main>

<?php include("piedepagina.php"); ?>

<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

const visor = document.getElementById("visor");
let documentoPdf = null;

async function dibujar(){
    const anchoVisor = visor.clientWidth;
    const escalaPantalla = window.devicePixelRatio || 1;
    const fragmento = document.createDocumentFragment();

    for(let n = 1; n <= documentoPdf.numPages; n++){
        const pagina = await documentoPdf.getPage(n);
        const base = pagina.getViewport({ scale: 1 });
        const escala = (anchoVisor / base.width) * escalaPantalla;
        const vista = pagina.getViewport({ scale: escala });

        const canvas = document.createElement("canvas");
        canvas.width = vista.width;
        canvas.height = vista.height;

        await pagina.render({
            canvasContext: canvas.getContext("2d"),
            viewport: vista
        }).promise;

        fragmento.appendChild(canvas);
    }

    visor.innerHTML = "";
    visor.appendChild(fragmento);
}

pdfjsLib.getDocument("../imagenesproyecto/fichaambiental.pdf").promise
    .then(function(pdf){
        documentoPdf = pdf;
        return dibujar();
    })
    .catch(function(){
        visor.innerHTML = '<div class="cargando">No se pudo cargar el PDF. <a href="fichaambiental.pdf" target="_blank" style="color:#fff">Abrir directamente</a></div>';
    });

let temporizador;
window.addEventListener("resize", function(){
    clearTimeout(temporizador);
    temporizador = setTimeout(function(){
        if(documentoPdf){ dibujar(); }
    }, 300);
});
</script>

</body>
</html>