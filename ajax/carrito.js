//==============================
// ABRIR CARRITO
//==============================

document.getElementById("carritoIcono")
.addEventListener("click",()=>{

    document.getElementById("sidebar")
    .classList.add("activo");

    document.getElementById("fondo")
    .classList.add("activo");

    actualizarCarrito();

});

//==============================
// CERRAR
//==============================

document.getElementById("cerrarCarrito")
.addEventListener("click",cerrarSidebar);

document.getElementById("fondo")
.addEventListener("click",cerrarSidebar);

function cerrarSidebar(){

    document.getElementById("sidebar")
    .classList.remove("activo");

    document.getElementById("fondo")
    .classList.remove("activo");

}
