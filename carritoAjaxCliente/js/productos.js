let listaProductos = [];
let pedidoActivo = false;


// Cuando carga la página
document.addEventListener("DOMContentLoaded", function() {
    verificarPedido();
});


// Verificar si existe un pedido activo
function verificarPedido() {

    fetch("php/verificar_pedido.php")

        .then(function(respuesta) {
            return respuesta.json();
        })

        .then(function(datos) {

            pedidoActivo = !!datos.pedidoActivo;

            cargarProductos();

        })

        .catch(function() {
            cargarProductos();
        });
}


// Obtener productos de la base de datos
function cargarProductos() {

    fetch("php/obtener_productos.php")

        .then(function(respuesta) {
            return respuesta.json();
        })

        .then(function(productos) {

            listaProductos = productos;

            mostrarProductos(productos);

        })

        .catch(function(error) {
            console.log(error);
        });
}


// Mostrar productos en la página
function mostrarProductos(productos) {

    let contenedor = document.getElementById("productos");

    let html = "";


    productos.forEach(function(producto) {

        html += `
            <div class="tarjeta">

                <img
                    src="${producto.imagen}"
                    width="150"
                >

                <h3>
                    ${producto.nombre}
                </h3>

                <p>
                    ${producto.descripcion}
                </p>

                <h2>
                    Bs ${producto.precio}
                </h2>

                <p>
                    Stock: ${producto.stock}
                </p>

                <button
                    class="btnAgregar"
                    data-codigo="${producto.id}"
                    ${pedidoActivo ? "" : "disabled"}
                >
                    Agregar al carrito
                </button>

            </div>
        `;

    });


    contenedor.innerHTML = html;

    agregarEventos();
}


// Agregar eventos a los botones
function agregarEventos() {

    document
        .querySelectorAll(".btnAgregar")
        .forEach(function(boton) {

            boton.addEventListener("click", function() {

                agregarProducto(
                    boton.dataset.codigo
                );

            });

        });
}


// Agregar producto al carrito
function agregarProducto(codigo) {

    fetch("php/carrito.php", {

        method: "POST",

        headers: {
            "Content-Type":
                "application/x-www-form-urlencoded"
        },

        body:
            "accion=agregar&codigo=" +
            encodeURIComponent(codigo)

    })

    .then(function(respuesta) {
        return respuesta.json();
    })

    .then(function(datos) {

        if(datos.ok) {

            actualizarCarrito();

        } else {

            alert(datos.mensaje);

        }

    })

    .catch(function(error) {
        console.log(error);
    });
}


// Habilitar botones de compra
function habilitarCompra() {

    pedidoActivo = true;

    document
        .querySelectorAll(".btnAgregar")
        .forEach(function(boton) {

            boton.disabled = false;

        });
}