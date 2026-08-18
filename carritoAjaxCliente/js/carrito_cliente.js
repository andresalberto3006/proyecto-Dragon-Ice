const API_CARRITO = "php/carrito_cliente.php";

function mostrarMensajeCliente(texto, error = false) {
    const elemento = document.getElementById("mensaje");
    elemento.textContent = texto;
    elemento.className = error ? "mensaje error" : "mensaje correcto";
}

async function cargarCarritoCliente() {
    try {
        const respuesta = await fetch(`${API_CARRITO}?accion=listar`, {
            cache: "no-store"
        });
        const data = await respuesta.json();

        const contenedor = document.getElementById("carritoContenido");
        const comprar = document.getElementById("btnComprar");

        if (!data.ok) {
            contenedor.innerHTML = `<p>${data.mensaje}</p>`;
            comprar.disabled = true;
            return;
        }

        if (data.productos.length === 0) {
            contenedor.innerHTML = "<p>Tu carrito está vacío.</p>";
            comprar.disabled = true;
            return;
        }

        let html = `<div class="lista-productos">`;

        data.productos.forEach(producto => {
            html += `
                <div class="producto-carrito">
                    <div>
                        <h3>${escapeHtml(producto.nombre)}</h3>
                        <p>Precio: Bs. ${producto.precio}</p>
                        <p>Subtotal: Bs. ${producto.subtotal}</p>
                    </div>

                    <div class="controles">
                        <button onclick="cambiarCantidadCliente(${producto.productos_id}, ${producto.cantidad - 1})">−</button>
                        <span>${producto.cantidad}</span>
                        <button onclick="cambiarCantidadCliente(${producto.productos_id}, ${producto.cantidad + 1})">+</button>
                        <button class="eliminar" onclick="eliminarProductoCliente(${producto.productos_id})">
                            Eliminar
                        </button>
                    </div>
                </div>
            `;
        });

        html += `
            </div>
            <div class="total">
                TOTAL: Bs. ${data.total}
            </div>
        `;

        contenedor.innerHTML = html;
        comprar.disabled = false;
    } catch (error) {
        console.error(error);
        mostrarMensajeCliente("No se pudo cargar el carrito.", true);
    }
}

async function agregarProductoCliente(idProducto, cantidad = 1) {
    if (!window.idPedidoCliente) {
        mostrarMensajeCliente("Primero debes crear un nuevo pedido.", true);
        return;
    }

    const respuesta = await fetch(API_CARRITO, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            accion: "agregar",
            idProducto,
            cantidad
        })
    });

    const data = await respuesta.json();

    if (!data.ok) {
        mostrarMensajeCliente(data.mensaje, true);
        return;
    }

    mostrarMensajeCliente("Producto agregado al carrito.");
    cargarCarritoCliente();
}

async function cambiarCantidadCliente(idProducto, cantidad) {
    if (cantidad <= 0) {
        await eliminarProductoCliente(idProducto);
        return;
    }

    const respuesta = await fetch(API_CARRITO, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            accion: "actualizar",
            idProducto,
            cantidad
        })
    });

    const data = await respuesta.json();

    if (!data.ok) {
        mostrarMensajeCliente(data.mensaje, true);
        return;
    }

    cargarCarritoCliente();
}

async function eliminarProductoCliente(idProducto) {
    const respuesta = await fetch(API_CARRITO, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            accion: "eliminar",
            idProducto
        })
    });

    const data = await respuesta.json();

    if (!data.ok) {
        mostrarMensajeCliente(data.mensaje, true);
        return;
    }

    cargarCarritoCliente();
}

document.getElementById("btnComprar").addEventListener("click", async () => {
    if (!window.idPedidoCliente) return;

    const nombre = prompt("Ingresa tu nombre:");
    if (!nombre || nombre.trim().length < 2) return;

    const metodoPago = prompt("Método de pago (QR, Efectivo, Tarjeta, etc.):");
    if (!metodoPago) return;

    const respuesta = await fetch("php/finalizar_pedido_cliente.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            nombre: nombre.trim(),
            metodo_pago: metodoPago.trim()
        })
    });

    const data = await respuesta.json();

    if (!data.ok) {
        mostrarMensajeCliente(data.mensaje, true);
        return;
    }

    window.location.href = `php/recibo_cliente.php?idPedido=${data.idPedido}`;
});

function escapeHtml(texto) {
    const div = document.createElement("div");
    div.textContent = texto;
    return div.innerHTML;
}

window.cargarCarritoCliente = cargarCarritoCliente;
window.agregarProductoCliente = agregarProductoCliente;
window.cambiarCantidadCliente = cambiarCantidadCliente;
window.eliminarProductoCliente = eliminarProductoCliente;
