const API_PEDIDO = "php/pedido_cliente.php";

async function verificarPedidoCliente() {
    try {
        const respuesta = await fetch(`${API_PEDIDO}?accion=verificar`, {
            cache: "no-store"
        });
        const data = await respuesta.json();

        const estado = document.getElementById("estadoPedido");
        const comprar = document.getElementById("btnComprar");

        if (data.ok && data.tiene_pedido) {
            estado.textContent = `Pedido #${data.idPedido} - Estado: ${data.estado}`;
            estado.className = "estado activo";

            window.idPedidoCliente = data.idPedido;

            if (window.cargarCarritoCliente) {
                window.cargarCarritoCliente();
            }
        } else {
            estado.textContent = "No tienes un pedido activo. Crea uno para comenzar.";
            estado.className = "estado sin-pedido";
            comprar.disabled = true;
        }
    } catch (error) {
        document.getElementById("estadoPedido").textContent =
            "No se pudo comprobar el pedido.";
        console.error(error);
    }
}

async function crearPedidoCliente() {
    try {
        const respuesta = await fetch(`${API_PEDIDO}?accion=crear`, {
            method: "POST",
            headers: {"Content-Type": "application/json"}
        });

        const data = await respuesta.json();

        if (!data.ok) {
            mostrarMensajeCliente(data.mensaje || "No se pudo crear el pedido.", true);
            return;
        }

        window.idPedidoCliente = data.idPedido;
        mostrarMensajeCliente(`Pedido #${data.idPedido} creado correctamente.`);
        await verificarPedidoCliente();
    } catch (error) {
        mostrarMensajeCliente("Error al crear el pedido.", true);
        console.error(error);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnNuevoPedido")
        .addEventListener("click", crearPedidoCliente);

    verificarPedidoCliente();
});
