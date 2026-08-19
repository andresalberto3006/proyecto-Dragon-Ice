let listaProductos = [];
let pedidoActivo = false;


document.addEventListener("DOMContentLoaded", function() {
    verificarPedido();
});


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


function habilitarCompra() {

    pedidoActivo = true;

    document
        .querySelectorAll(".btnAgregar")
        .forEach(function(boton) {

            boton.disabled = false;

        });
}