
document.addEventListener(
    "DOMContentLoaded",
    function() {

        verificarEstadoPedido();

    }
);


document
    .getElementById("generarPedido")
    .addEventListener("click", function() {

        document
            .getElementById("modalCompra")
            .style.display = "flex";

    });


document
    .getElementById("cancelarCompra")
    .addEventListener("click", function() {

        document
            .getElementById("modalCompra")
            .style.display = "none";

    });


document
    .getElementById("confirmarPedido")
    .addEventListener("click", function() {

        let datos = {

            nombre:
                document.getElementById("nombre").value,

            telefono:
                document.getElementById("telefono").value,

            direccion:
                document.getElementById("direccion").value,

            metodo:
                document.getElementById("metodoPago").value

        };


        fetch("php/crear_pedido.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify(datos)

        })

        .then(function(respuesta) {
            return respuesta.json();
        })

        .then(function(datos) {

            if(datos.ok) {

                alert(
                    "Pedido confirmado Nº " +
                    datos.pedido
                );


                document
                    .getElementById("modalCompra")
                    .style.display = "none";


                habilitarCompra();


                location.reload();

            } else {

                alert(datos.mensaje);

            }

        })

        .catch(function(error) {
            console.log(error);
        });

    });


function verificarEstadoPedido() {

    fetch("php/estado_pedido.php")

        .then(function(respuesta) {
            return respuesta.json();
        })

        .then(function(datos) {

            if(
                datos.ok &&
                datos.pedido.Estado === "Pendiente"
            ) {

                let formulario =
                    document.getElementById(
                        "formularioPedido"
                    );

                let resumen =
                    document.getElementById(
                        "resumenPedido"
                    );


                if(formulario) {
                    formulario.style.display = "none";
                }


                if(resumen) {
                    resumen.style.display = "block";
                }


                let datosPedido =
                    document.getElementById(
                        "datosPedido"
                    );


                if(datosPedido) {

                    datosPedido.innerHTML = `

                        <p>
                            Número pedido:
                            ${datos.pedido.id}
                        </p>

                        <p>
                            Cliente:
                            ${datos.pedido.Nombre}
                        </p>

                        <p>
                            Teléfono:
                            ${datos.pedido.telefono}
                        </p>

                        <p>
                            Dirección:
                            ${datos.pedido.direccion}
                        </p>

                        <p>
                            Método pago:
                            ${datos.pedido.metodoPago}
                        </p>

                        <p>
                            Estado:
                            Pendiente de aprobación
                        </p>

                    `;

                }

            }

        })

        .catch(function(error) {
            console.log(error);
        });
}