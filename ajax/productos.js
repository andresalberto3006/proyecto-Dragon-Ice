let listaProductos = [];

 document.addEventListener("DOMContentLoaded",()=>{

    cargarProductos();

});
let pedidoActivo = false;


function cargarProductos(){
/*fetch() es una función de JavaScript que permite realizar peticiones HTTP al servidor.

En este caso envía una petición al archivo:*/
    fetch("php/obtener_productos.php")
/*Cuando el servidor responde, esa respuesta aún no es un objeto de JavaScript.

Es simplemente una respuesta HTTP. Es decir, transforma el JSON recibido en datos que JavaScript puede utilizar.*/ 
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

    productos.forEach(productos=>{

        html += `
        <div class="tarjeta">

            <img src="img/productos/${productos.imagen}" alt="${producto.nombre}">

            <h3>${productos.nombre}</h3>

            <p>${productos.descripcion}</p>

            <h2>Bs ${productos.precio}</h2>

            

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

            agregarProductos(boton.dataset.codigo);

        });

    });

}
