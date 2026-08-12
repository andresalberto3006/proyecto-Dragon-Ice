function buscar(){

    var nombre =document.getElementById("textoBuscar").value;

    fetch("buscar_productos.php?nombre="+nombre)

    .then(res=>res.json())

    .then(data=>{

        console.log(data);

        var html="";

        data.forEach(productos=>{

            html += `

            <h3>${productos.nombre}</h3>

            <p>
            Precio: Bs ${productos.precio}
            </p>

            <hr>

            `;

        });

        document.getElementById("productos").innerHTML = html;

    });

}