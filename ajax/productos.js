let listaProductos = [];
 
 document.addEventListener("DOMContentLoaded",()=>{
 
    cargarProductos();
 
});
let pedidoActivo = false;
 
 
function cargarProductos(){

    fetch("php/obtener_productos.php")

    .then(respuesta => respuesta.json())
 
    .then(productos => {
 
        listaProductos = productos;
 
        mostrarProductos(productos);
 
    })
 
    .catch(error => console.log(error));
 
}
function mostrarProductos(productos){
 
    let contenedor = document.getElementById("productos");
 
    let html = "";
 
    productos.forEach(producto=>{
 
        html += `
        <div class="tarjeta">
 
            <img src="${producto.imagen}" alt="${producto.nombre}">
 
            <h3>${producto.nombre}</h3>
 
            <p>${producto.descripcion}</p>
 
            <h2>Bs ${producto.precio}</h2>
 
            <button class="btnAgregar" data-id="${producto.id}">Agregar</button>
 
        </div>
        `;
 
    });
 
    contenedor.innerHTML = html;
 
    // IMPORTANTE
    agregarEventos();
 
}
function agregarEventos(){
 
    document.querySelectorAll(".btnAgregar").forEach(boton=>{
 
        boton.addEventListener("click",()=>{
 
            agregarProductos(boton.dataset.id);
 
        });
 
    });
 
}
