
document
    .getElementById("carritoIcono")
    .addEventListener("click", function() {

        document
            .getElementById("sidebar")
            .classList.add("activo");

        document
            .getElementById("fondo")
            .classList.add("activo");

        actualizarCarrito();

    });


document
    .getElementById("cerrarCarrito")
    .addEventListener("click", cerrarSidebar);


document
    .getElementById("fondo")
    .addEventListener("click", cerrarSidebar);


function cerrarSidebar() {

    document
        .getElementById("sidebar")
        .classList.remove("activo");

    document
        .getElementById("fondo")
        .classList.remove("activo");
}


function actualizarCarrito() {

    fetch("php/carrito.php", {

        method: "POST",

        headers: {
            "Content-Type":
                "application/x-www-form-urlencoded"
        },

        body: "accion=mostrar"

    })

    .then(function(respuesta) {
        return respuesta.json();
    })

    .then(function(datos) {

        if(!Array.isArray(datos)) {
            return;
        }


        let html = "";

        let total = 0;

        let cantidad = 0;


        datos.forEach(function(producto) {

            let subtotal =
                Number(producto.costototal);

            let cantidadProducto =
                Number(producto.cantidad);


            total += subtotal;

            cantidad += cantidadProducto;


            html += `

                <div class="productoCarrito">

                    <img
                        src="${producto.imagen}"
                        width="80"
                    >

                    <h3>
                        ${producto.nombre}
                    </h3>

                    <p>
                        Precio:
                        Bs ${producto.precio}
                    </p>

                    <p>
                        Cantidad:
                        ${cantidadProducto}
                    </p>

                    <p>
                        Subtotal:
                        Bs ${subtotal.toFixed(2)}
                    </p>

                </div>

            `;

        });


        document
            .getElementById("contenidoCarrito")
            .innerHTML =
                html || "<p>Carrito vacío</p>";


        document
            .getElementById("cantidadCarrito")
            .innerHTML =
                cantidad;


        document
            .getElementById("totalCarrito")
            .innerHTML =
                "Total: Bs " +
                total.toFixed(2);

    })

    .catch(function(error) {
        console.log(error);
    });
}


document
    .getElementById("vaciarCarrito")
    .addEventListener("click", vaciarCarrito);


function vaciarCarrito() {

    if(!confirm("¿Desea vaciar todo el carrito?")) {
        return;
    }


    fetch("php/carrito.php", {

        method: "POST",

        headers: {
            "Content-Type":
                "application/x-www-form-urlencoded"
        },

        body: "accion=vaciar"

    })

    .then(function(respuesta) {
        return respuesta.json();
    })

    .then(function(datos) {

        if(datos.ok) {

            actualizarCarrito();

        } else {

            alert(datos.mensaje);

        }

    })

    .catch(function(error) {
        console.log(error);
    });
}


document.addEventListener("click", function(event) {

    if(event.target.id === "comprar") {

        fetch("php/finalizar_pedido.php")

            .then(function(respuesta) {
                return respuesta.json();
            })

            .then(function(datos) {

                if(datos.ok) {

                    location.href = "recibo.php";

                } else {

                    alert(datos.mensaje);

                }

            })

            .catch(function(error) {
                console.log(error);
            });
    }

});