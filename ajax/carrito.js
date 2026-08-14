
// Agregar producto al carrito
document.querySelectorAll('.btn-agregar').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        const respuesta = await fetch('agregar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_producto=${id}&cantidad=1`
        });
        const data = await respuesta.json();
        if (data.exito) {
            actualizarVista(data);
        } else {
            alert(data.mensaje || 'Error al agregar el producto');
        }
    });
});
 
// Quitar producto del carrito (delegación de eventos porque estos botones se crean dinámicamente)
document.getElementById('lista-carrito').addEventListener('click', async (e) => {
    if (e.target.classList.contains('btn-quitar')) {
        const id = e.target.dataset.id;
        const respuesta = await fetch('eliminar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_producto=${id}`
        });
        const data = await respuesta.json();
        if (data.exito) {
            actualizarVista(data);
        }
    }
});
 
function actualizarVista(data) {
    document.getElementById('contador-carrito').textContent = data.total_items;
    document.getElementById('total-carrito').textContent = data.total_precio.toFixed(2);
 
    const contenedor = document.getElementById('lista-carrito');
    if (data.items.length === 0) {
        contenedor.innerHTML = '<p>El carrito está vacío</p>';
        return;
    }
 
    contenedor.innerHTML = data.items.map(item => `
        <div class="item-carrito">
            <span>${item.nombre} x${item.cantidad} — $${(item.precio * item.cantidad).toFixed(2)}</span>
            <button class="btn-quitar" data-id="${item.id}">Quitar</button>
        </div>
    `).join('');
}
 
// Cargar el carrito al abrir la página (por si ya tenía productos guardados en sesión)
window.addEventListener('DOMContentLoaded', async () => {
    const respuesta = await fetch('ver_carrito.php');
    const data = await respuesta.json();
    actualizarVista(data);
});