var modal = document.getElementById("modalCompra");

modal.style.display = "none";


document
    .getElementById("generarPedido")
    .addEventListener("click", function() {

        if (pedidoActivo) {

            Swal.fire({
                title: "Ya tienes un pedido abierto",
                text: "Puedes seguir agregando productos al carrito.",
                icon: "info",
                confirmButtonColor: "#0e2a4d"
            });

            return;
        }

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
                modal.style.display = "flex";
            }

        });

    });


document
    .getElementById("cancelarCompra")
    .addEventListener("click", function() {

        modal.style.display = "none";

    });


document
    .getElementById("confirmarPedido")
    .addEventListener("click", function() {

        if (!$("#formularioPedido").valid()) {
            return;
        }

        var boton = this;
        boton.disabled = true;

        let datos = {
            nombre: document.getElementById("nombre").value,
            telefono: document.getElementById("telefono").value,
            direccion: document.getElementById("direccion").value,
            metodo: document.getElementById("metodoPago").value
        };

        fetch("php/crear_pedido.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        })

        .then(function(respuesta) {
            return respuesta.text();
        })

        .then(function(texto) {

            var respuesta;

            try {
                respuesta = JSON.parse(texto);
            } catch (e) {
                console.log(texto);
                modal.style.display = "none";
                boton.disabled = false;
                alert("El servidor respondió con un error. Abre la consola (F12) para verlo.");
                return;
            }

            boton.disabled = false;

            if (respuesta.ok) {

                modal.style.display = "none";

                Swal.fire({
                    title: "¡Pedido realizado con éxito!",
                    text: "Tu pedido Nº " + respuesta.pedido + " fue registrado. Ya puedes agregar productos al carrito.",
                    icon: "success",
                    confirmButtonText: "Continuar",
                    confirmButtonColor: "#28a745",
                    allowOutsideClick: false
                }).then(function() {

                    location.reload();

                });

            } else {

                alert(respuesta.mensaje);

            }

        })

        .catch(function(error) {
            console.log(error);
            boton.disabled = false;
            modal.style.display = "none";
        });

    });