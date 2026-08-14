
document.addEventListener("DOMContentLoaded", () => {

    console.log("pedido.js cargado");

    document.getElementById("generarPedido").addEventListener("click", () => {

        console.log("Click");

        window.location.href = "pedido.php";

    });

});