document.getElementById('consultar').addEventListener('click',()=>{
let id=document.getElementById('numeroPedido').value;
fetch('php/consultar_pedido.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'id='+encodeURIComponent(id)})
.then(r=>r.json())
.then(d=>{
let x=document.getElementById('resultado');
if(d.ok){
let p=d.pedido;
x.innerHTML=`<div class="resultado">
<h3>Pedido Nº ${p.id}</h3>
<div class="dato"><b>Cliente:</b> ${p.Nombre}</div>
<div class="dato"><b>Fecha:</b> ${p.Fecha}</div>
<div class="dato"><b>Estado:</b> <span class="estado">${p.Estado}</span></div>
<div class="dato"><b>Vendedor:</b> ${p.NombreVendedor??'Pendiente'}</div>
</div>`;
}else{
x.innerHTML='<div class="resultado"><p>Pedido no encontrado.</p></div>';
}
})
.catch(()=>document.getElementById('resultado').innerHTML='<div class="resultado"><p>Error al consultar el pedido.</p></div>');
});