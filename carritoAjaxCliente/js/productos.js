let listaProductos=[];let pedidoActivo=false;document.addEventListener('DOMContentLoaded',()=>verificarPedido());
function cargarProductos(){fetch('php/obtener_productos.php').then(r=>r.json()).then(p=>{listaProductos=p;mostrarProductos(p)}).catch(console.log)}
function mostrarProductos(productos){let c=document.getElementById('productos'),html='';productos.forEach(p=>{html+=`<div class="tarjeta"><img src="${p.imagen}" width="150"><h3>${p.nombre}</h3><p>${p.descripcion}</p><h2>Bs ${p.precio}</h2><p>Stock: ${p.stock}</p><button class="btnAgregar" data-codigo="${p.id}" ${pedidoActivo?'':'disabled'}>Agregar al carrito</button></div>`});c.innerHTML=html;agregarEventos()}
function agregarEventos(){document.querySelectorAll('.btnAgregar').forEach(b=>b.addEventListener('click',()=>agregarProducto(b.dataset.codigo)))}
function agregarProducto(codigo){fetch('php/carrito.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'accion=agregar&codigo='+encodeURIComponent(codigo)}).then(r=>r.json()).then(d=>d.ok?actualizarCarrito():alert(d.mensaje)).catch(console.log)}
function habilitarCompra(){pedidoActivo=true;document.querySelectorAll('.btnAgregar').forEach(b=>b.disabled=false)}
function verificarPedido(){fetch('php/verificar_pedido.php').then(r=>r.json()).then(d=>{pedidoActivo=!!d.pedidoActivo;cargarProductos()}).catch(()=>cargarProductos())}
