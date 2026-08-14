function buscarProducto(){


fetch("productos.php")


.then(respuesta => respuesta.json())


.then(datos => {


let html="";


datos.forEach(productos => {


html += `

<h3>${productos.nombre}</h3>
<img src="img/productos/${productos.imagen}" width="100">

<p>
Descripción: ${productos.descripcion}
</p>

<p>
Precio: Bs ${productos.precio}
</p>

<p>
Stock: ${productos.stock}
</p>

<hr>

`;


});

/*aqui le estamos diciendo que todo lo anterior lo pongamos en el div que se llama resultado con su id*/
document.getElementById("resultado")
.innerHTML = html;


});


}