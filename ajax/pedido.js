document.addEventListener("DOMContentLoaded",()=>{
 
verificarEstadoPedido();
 
});
 
 

 
 
document.getElementById("generarPedido").addEventListener("click",()=>{
 
    document
    .getElementById("modalCompra")
    .style.display="flex";
 
});
 

 
document.getElementById("cancelarCompra").addEventListener("click",()=>{
 
    document.getElementById("modalCompra")
    .style.display="none";
 
});

document.getElementById("confirmarPedido").addEventListener("click",()=>{
      
 
    let datos = {
 
        nombre: document.getElementById("nombre").value,
        metodo_pago: document.getElementById("metodoPago").value,
    
 
    };
 
 
 
fetch("crearpedido.php",{
 
    method:"POST",
 
    headers:{
        "Content-Type":"application/json"
    },
 
    body: JSON.stringify(datos)
 
})
 
 
.then(res=>res.json())
 
 
.then(data=>{
 
 
    console.log(data);
 
 
    if(data.ok){
 
 
        alert(
        "Pedido confirmado Nº "
        + data.pedido
        );
 
 
         window.location.href="indexpaginaprincipal.php?id="+data.pedido;
 
 
    }else{
 
 
        alert(data.mensaje);
 
 
    }
 
 
})
 
 
.catch(error=>{
 
    console.log("Error:",error);
 
});
 
 
});
function verificarEstadoPedido(){
 
 
fetch("estadopedido.php")
 
 
.then(res=>res.json())
 
 
.then(data=>{
 
 
if(data.ok){
 
 
let pedido=data.pedido;
 
 
 
if(pedido.estado=="Pendiente"){
 
 
 
document.getElementById("formularioPedido").style.display="none";
 
 
 
document.getElementById("resumenPedido").style.display="block";
 
 
 
document.getElementById("datosPedido").innerHTML=`
 
<p>
Número pedido:
${pedido.id}
</p>
 
 
<p>
Cliente:
${pedido.nombre}
</p>
 
 
<p>
Vendedor:
${pedido.nombrevendedor}
</p>
 
 
<p>
Método pago:
${pedido.metodo_pago}
</p>
 
 
<p>
Estado:
Pendiente de aprobación
</p>
 
 
`;
 
 
 
}
 
 
}
 
 
 
});
 
 
}