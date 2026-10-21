
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
            console.log("Error al cargar productos:", error);
        });
}

function mostrarProductos(productos) {
    const contenedor = document.getElementById("productos");

    if (!contenedor) return;

    let html = "";

    productos.forEach(function(producto) {
        const stock = Math.max(0, Number(producto.stock) || 0);
        const precio = Number(producto.precio) || 0;

        html += `
            <div class="tarjeta">

                <img
                    class="imagenProducto"
                    src="${producto.imagen}"
                    alt="${producto.nombre}"
                    loading="lazy"
                >

                <h3>${producto.nombre}</h3>

                <p class="descripcionProducto">
                    ${producto.descripcion || ""}
                </p>

                <h2 class="precioProducto">
                    Bs ${precio.toFixed(2)}
                </h2>

                <p class="stockProducto">
                    Stock: ${stock}
                </p>

                <div class="cantidadProducto">
                    <button
                        type="button"
                        class="btnCantidad"
                        data-accion="menos"
                        data-codigo="${producto.id}"
                        aria-label="Disminuir cantidad"
                        ${!pedidoActivo || stock < 1 ? "disabled" : ""}
                    >−</button>

                    <input
                        type="number"
                        class="numeroCantidad"
                        data-codigo="${producto.id}"
                        value="${stock > 0 ? 1 : 0}"
                        min="${stock > 0 ? 1 : 0}"
                        max="${stock}"
                        ${!pedidoActivo || stock < 1 ? "disabled" : ""}
                        aria-label="Cantidad de ${producto.nombre}"
                    >

                    <button
                        type="button"
                        class="btnCantidad"
                        data-accion="mas"
                        data-codigo="${producto.id}"
                        aria-label="Aumentar cantidad"
                        ${!pedidoActivo || stock < 1 ? "disabled" : ""}
                    >+</button>
                </div>

                <button
                    type="button"
                    class="btnAgregar"
                    data-codigo="${producto.id}"
                    ${!pedidoActivo || stock < 1 ? "disabled" : ""}
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
    document.querySelectorAll(".btnCantidad").forEach(function(boton) {
        boton.addEventListener("click", function() {
            const codigo = boton.dataset.codigo;
            const accion = boton.dataset.accion;

            const producto = listaProductos.find(function(item) {
                return String(item.id) === String(codigo);
            });

            const input = document.querySelector(
                '.numeroCantidad[data-codigo="' + codigo + '"]'
            );

            if (!producto || !input) return;

            const stock = Number(producto.stock) || 0;
            let cantidad = Number(input.value) || 1;

            if (accion === "mas" && cantidad < stock) {
                cantidad++;
            }

            if (accion === "menos" && cantidad > 1) {
                cantidad--;
            }

            input.value = cantidad;
        });
    });

    document.querySelectorAll(".numeroCantidad").forEach(function(input) {
        input.addEventListener("change", function() {
            const producto = listaProductos.find(function(item) {
                return String(item.id) === String(input.dataset.codigo);
            });

            if (!producto) return;

            const stock = Number(producto.stock) || 0;
            let cantidad = parseInt(input.value, 10);

            if (isNaN(cantidad)) cantidad = 1;

            cantidad = Math.max(1, Math.min(cantidad, stock));
            input.value = stock > 0 ? cantidad : 0;
        });
    });

    document.querySelectorAll(".btnAgregar").forEach(function(boton) {
        boton.addEventListener("click", function() {
            const codigo = boton.dataset.codigo;

            const input = document.querySelector(
                '.numeroCantidad[data-codigo="' + codigo + '"]'
            );

            if (!input) return;

            const cantidad = parseInt(input.value, 10);

            if (!cantidad || cantidad < 1) {
                alert("Selecciona una cantidad válida.");
                return;
            }

            agregarProducto(codigo, cantidad);
        });
    });
}

function agregarProducto(codigo, cantidad) {
    const boton = document.querySelector(
        '.btnAgregar[data-codigo="' + codigo + '"]'
    );

    if (boton) boton.disabled = true;

    const datos = new URLSearchParams();
    datos.append("accion", "agregar");
    datos.append("codigo", codigo);
    datos.append("cantidad", cantidad);

    fetch("php/carrito.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: datos.toString()
    })
    .then(function(respuesta) {
        return respuesta.json();
    })
    .then(function(datos) {
        if (datos.ok) {
            if (typeof actualizarCarrito === "function") {
                actualizarCarrito();
            }

            const input = document.querySelector(
                '.numeroCantidad[data-codigo="' + codigo + '"]'
            );

            if (input) input.value = 1;
        } else {
            alert(datos.mensaje || "No se pudo agregar el producto.");
        }
    })
    .catch(function(error) {
        console.log("Error al agregar producto:", error);
        alert("Ocurrió un error al agregar el producto.");
    })
    .finally(function() {
        if (boton) boton.disabled = false;
    });
}

function habilitarCompra() {
    pedidoActivo = true;
    mostrarProductos(listaProductos);
}
