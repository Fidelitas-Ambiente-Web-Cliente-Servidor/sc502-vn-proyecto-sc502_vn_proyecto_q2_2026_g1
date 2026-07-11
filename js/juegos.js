const opcionesJuego = document.querySelectorAll(".opcion-juego");

opcionesJuego.forEach(function (opcion) {
    opcion.addEventListener("click", function () {
        const juego = opcion.dataset.juego;

        if (juego === "oracion") {
            window.location.href = "leccion-oracion.html";
        }

        if (juego === "crucigrama") {
            alert("Crucigramas estará disponible próximamente.");
        }

        if (juego === "ordenar") {
            alert("Ordenar las palabras estará disponible próximamente.");
        }
    });
});