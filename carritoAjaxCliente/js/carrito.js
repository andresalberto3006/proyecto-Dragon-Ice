
document.addEventListener("DOMContentLoaded", function() {

    const carritoIcono = document.getElementById("carritoIcono");
    const sidebar = document.getElementById("sidebar");
    const fondo = document.getElementById("fondo");
    const cerrarCarrito = document.getElementById("cerrarCarrito");
    const vaciarBoton = document.getElementById("vaciarCarrito");

    if (carritoIcono) {
        carritoIcono.addEventListener("click", function() {
            if (sidebar) sidebar.classList.add("activo");
            if (fondo) fondo.classList.add("activo");

            actualizarCarrito();
        });
    }

    if (cerrarCarrito) {
        cerrarCarrito.addEventListener("click", cerrarSidebar);
    }

    if (fondo) {
        fondo.addEventListener("click", cerrarSidebar);
    }

    if (vaciarBoton) {
        vaciarBoton.addEventListener("click", vaciarCarrito);
    }

    document.addEventListener("click", function(event) {
        if (event.target.closest("#comprar")) {
            finalizarPedido();
        }
    });

    actualizarCarrito();
});


function cerrarSidebar() {
    const sidebar = document.getElementById("sidebar");
    const fondo = document.getElementById("fondo");

    if (sidebar) sidebar.classList.remove("activo");
    if (fondo) fondo.classList.remove("activo");
}


function actualizarCarrito() {

    fetch("php/carrito.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "accion=mostrar"
    })
    .then(function(respuesta) {
        return respuesta.json();
    })
    .then(function(datos) {

        if (!Array.isArray(datos)) {
            console.log("Respuesta del carrito:", datos);
            return;
        }

        let html = "";
        let total = 0;
        let cantidad = 0;

        datos.forEach(function(producto) {

            const precio = Number(producto.precio) || 0;
            const subtotal = Number(producto.costototal) || 0;
            const cantidadProducto = Number(producto.cantidad) || 0;

            total += subtotal;
            cantidad += cantidadProducto;

            html += `
                <div class="productoCarrito">

                    <img
                        src="${producto.imagen}"
                        alt="${producto.nombre}"
                    >

                    <div class="datosCarrito">
                        <h3>${producto.nombre}</h3>

                        <p>Precio: Bs ${precio.toFixed(2)}</p>

                        <p>Cantidad: ${cantidadProducto}</p>

                        <p>Subtotal: Bs ${subtotal.toFixed(2)}</p>
                    </div>

                </div>
            `;
        });

        const contenido = document.getElementById("contenidoCarrito");
        const contador = document.getElementById("cantidadCarrito");
        const totalElemento = document.getElementById("totalCarrito");

        if (contenido) {
            contenido.innerHTML = html || "<p>Carrito vacío</p>";
        }

        if (contador) {
            contador.textContent = cantidad;
        }

        if (totalElemento) {
            totalElemento.textContent = "Total: Bs " + total.toFixed(2);
        }
    })
    .catch(function(error) {
        console.error("Error al actualizar el carrito:", error);
    });
}


function vaciarCarrito() {

    if (!confirm("¿Desea vaciar todo el carrito?")) {
        return;
    }

    fetch("php/carrito.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "accion=vaciar"
    })
    .then(function(respuesta) {
        return respuesta.json();
    })
    .then(function(datos) {

        if (datos.ok) {
            actualizarCarrito();
        } else {
            alert(datos.mensaje || "No se pudo vaciar el carrito.");
        }
    })
    .catch(function(error) {
        console.error("Error al vaciar el carrito:", error);
    });
}


function finalizarPedido() {

    fetch("php/finalizar_pedido.php")
    .then(function(respuesta) {
        return respuesta.json();
    })
    .then(function(datos) {

        if (datos.ok) {
            location.href =
                "../pedidos/detallePedido.php?id=" + datos.pedido;
        } else {
            alert(datos.mensaje || "No se pudo finalizar el pedido.");
        }
    })
    .catch(function(error) {
        console.error("Error al finalizar el pedido:", error);
    });
}
