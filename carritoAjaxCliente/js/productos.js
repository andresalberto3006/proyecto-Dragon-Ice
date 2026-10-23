let listaProductos = [];
let pedidoActivo = false;
let cantidades = {};
let procesando = false;


document.addEventListener("DOMContentLoaded", function() {

    document
        .getElementById("productos")
        .addEventListener("click", clickProductos);

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
                    alt="${producto.nombre}"
                >

                <div class="info">

                    <h3>
                        ${producto.nombre}
                    </h3>

                    <p>
                        ${producto.descripcion}
                    </p>

                    <h2>
                        Bs ${producto.precio}
                    </h2>

                    <span class="stock">
                        Stock: ${producto.stock}
                    </span>

                </div>

                <div class="zonaCompra" id="zona-${producto.id}">

                    <button
                        class="btnAgregar"
                        data-codigo="${producto.id}"
                        ${pedidoActivo ? "" : "disabled"}
                    >
                        Agregar al carrito
                    </button>

                    <div class="selector">

                        <button
                            class="btnMenos"
                            data-codigo="${producto.id}"
                        >
                            −
                        </button>

                        <span class="cantidadProducto">0</span>

                        <button
                            class="btnMas"
                            data-codigo="${producto.id}"
                        >
                            +
                        </button>

                    </div>

                </div>

            </div>
        `;

    });


    contenedor.innerHTML = html;

    productos.forEach(function(producto) {
        pintarCantidad(producto.id);
    });
}


function clickProductos(evento) {

    let boton = evento.target.closest("button");

    if(!boton) {
        return;
    }

    let codigo = boton.dataset.codigo;

    if(boton.classList.contains("btnAgregar") || boton.classList.contains("btnMas")) {
        cambiarCantidad(codigo, "agregar");
    }

    if(boton.classList.contains("btnMenos")) {
        cambiarCantidad(codigo, "restar");
    }
}


function cambiarCantidad(codigo, accion) {

    if(procesando) {
        return;
    }

    procesando = true;

    fetch("php/carrito.php", {

        method: "POST",

        headers: {
            "Content-Type":
                "application/x-www-form-urlencoded"
        },

        body:
            "accion=" + accion +
            "&codigo=" + encodeURIComponent(codigo)

    })

    .then(function(respuesta) {
        return respuesta.json();
    })

    .then(function(datos) {

        procesando = false;

        if(datos.ok) {

            actualizarCarrito();

        } else {

            Swal.fire({
                icon: "warning",
                title: datos.mensaje,
                confirmButtonColor: "#0e2a4d"
            });

        }

    })

    .catch(function(error) {
        procesando = false;
        console.log(error);
    });
}


function pintarCantidad(codigo) {

    let zona = document.getElementById("zona-" + codigo);

    if(!zona) {
        return;
    }

    let cantidad = cantidades[codigo] ? cantidades[codigo] : 0;

    let stock = 0;

    listaProductos.forEach(function(producto) {
        if(String(producto.id) === String(codigo)) {
            stock = Number(producto.stock);
        }
    });

    zona.querySelector(".cantidadProducto").innerHTML = cantidad;

    zona.querySelector(".btnMas").disabled = cantidad >= stock;

    if(cantidad > 0) {
        zona.classList.add("conCantidad");
    } else {
        zona.classList.remove("conCantidad");
    }
}


function sincronizarCantidades(items) {

    cantidades = {};

    items.forEach(function(item) {
        cantidades[item.productos_id] = Number(item.cantidad);
    });

    listaProductos.forEach(function(producto) {
        pintarCantidad(producto.id);
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