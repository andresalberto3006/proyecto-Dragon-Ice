function cargarMensajes(){
    
    fetch("mensaje.php")

    .then(respuesta => respuesta.text())

    .then(datos => {

        document.getElementById("mensaje").innerHTML = datos;
    })
}