document.addEventListener(
    "DOMContentLoaded",
    function() {

        verificarEstadoPedido();

    }
);


document
    .getElementById("generarPedido")
    .addEventListener("click", function() {

        Swal.fire({
            title: "¿Deseas realizar el pedido?",
            text: "Se abrirá el formulario para completar tus datos.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#d33"
        }).then(function(resultado) {

            if (resultado.isConfirmed) {

                document
                    .getElementById("modalCompra")
                    .style.display = "flex";

            }

        });

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

                document
                    .getElementById("modalCompra")
                    .style.display = "none";

                Swal.fire({
                    title: "¡Pedido realizado con éxito!",
                    text: "Tu pedido Nº " + datos.pedido + " fue registrado y quedará pendiente de aprobación.",
                    icon: "success",
                    confirmButtonText: "Continuar",
                    confirmButtonColor: "#28a745"
                }).then(function() {

                    habilitarCompra();
                    location.reload();

                });

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