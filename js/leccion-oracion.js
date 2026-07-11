const opciones = document.querySelectorAll(".opcion-respuesta");
const btnComprobar = document.getElementById("btnComprobar");
const mensajeRespuesta = document.getElementById("mensajeRespuesta");
const barraProgreso = document.getElementById("barraProgreso");
const textoProgreso = document.getElementById("textoProgreso");

let respuestaSeleccionada = "";
const respuestaCorrecta = "Pájaro";

opciones.forEach(function (opcion) {
    opcion.addEventListener("click", function () {
        respuestaSeleccionada = opcion.dataset.respuesta;

        opciones.forEach(function (boton) {
            boton.style.outline = "none";
            boton.style.transform = "scale(1)";
        });

        opcion.style.outline = "4px solid #7bb56b";
        opcion.style.transform = "scale(1.04)";
    });
});

btnComprobar.addEventListener("click", function () {
    if (respuestaSeleccionada === "") {
        mensajeRespuesta.textContent = "Seleccione una respuesta antes de comprobar.";
        mensajeRespuesta.style.color = "#b34747";
        return;
    }

    let correctas = 20;
    let incorrectas = 3;

    if (respuestaSeleccionada === respuestaCorrecta) {
        correctas++;
        mensajeRespuesta.textContent = "¡Correcto!";
        mensajeRespuesta.style.color = "#4f9b4f";
    } else {
        incorrectas++;
        mensajeRespuesta.textContent = "Respuesta incorrecta.";
        mensajeRespuesta.style.color = "#b34747";
    }

    localStorage.setItem("juegoNombre", "Completar la Oración");
    localStorage.setItem("juegoCorrectas", correctas);
    localStorage.setItem("juegoIncorrectas", incorrectas);

    barraProgreso.style.width = "100%";
    textoProgreso.textContent = "100%";

    setTimeout(function () {
        window.location.href = "retroalimentacion.html";
    }, 900);
});