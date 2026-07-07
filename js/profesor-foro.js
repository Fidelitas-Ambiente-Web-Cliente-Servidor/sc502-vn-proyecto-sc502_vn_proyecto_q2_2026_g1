// Preguntas del foro administradas por el profesor (datos simulados, listos para conectarse al backend PHP)
const preguntasForoProfesor = [
    { dibujo: "🦒", respuesta: "jirafa" },
    { dibujo: "🐘", respuesta: "elefante" },
    { dibujo: "🐢", respuesta: "tortuga" },
    { dibujo: "🦁", respuesta: "leon" }
];

let indiceActual = 0;

const dibujo = document.getElementById("dibujo");
const entrada = document.getElementById("respuesta");
const contador = document.getElementById("contador");
const btnAnterior = document.getElementById("btnAnterior");
const btnAgregar = document.getElementById("btnAgregar");

function mostrarPregunta() {
    const pregunta = preguntasForoProfesor[indiceActual];
    dibujo.textContent = pregunta.dibujo;
    entrada.value = pregunta.respuesta;
    contador.textContent = "Pregunta " + (indiceActual + 1) + " de " + preguntasForoProfesor.length;
    entrada.focus();
}

btnAnterior.addEventListener("click", function () {
    if (indiceActual > 0) {
        indiceActual--;
        mostrarPregunta();
    }
});

btnAgregar.addEventListener("click", function () {
    const respuesta = entrada.value.trim().toLowerCase();

    if (respuesta === "") {
        contador.textContent = "Escribe la respuesta correcta antes de agregar";
        return;
    }

    preguntasForoProfesor[indiceActual].respuesta = respuesta;

    if (indiceActual < preguntasForoProfesor.length - 1) {
        indiceActual++;
        mostrarPregunta();
    } else {
        contador.textContent = "Todas las preguntas del foro fueron guardadas";
    }
});

entrada.addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
        btnAgregar.click();
    }
});

mostrarPregunta();