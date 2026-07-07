const preguntasForo = [
    { dibujo: "🦒", respuesta: "jirafa" },
    { dibujo: "🐘", respuesta: "elefante" },
    { dibujo: "🐢", respuesta: "tortuga" },
    { dibujo: "🦁", respuesta: "leon" }
];

let actual = 0;

const dibujo = document.getElementById("dibujo");
const entrada = document.getElementById("respuesta");
const feedback = document.getElementById("feedback");
const btnAnterior = document.getElementById("btnAnterior");
const btnSiguiente = document.getElementById("btnSiguiente");

function mostrarPregunta() {
    dibujo.textContent = preguntasForo[actual].dibujo;
    entrada.value = "";
    feedback.textContent = "";
    entrada.focus();
}

function limpiarTexto(texto) {
    return texto.trim().toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

btnSiguiente.onclick = function () {
    const escrito = limpiarTexto(entrada.value);

    if (escrito === "") {
        feedback.textContent = "Escribe una respuesta";
        feedback.className = "mensaje-feedback incorrecto";
        return;
    }

    if (escrito === preguntasForo[actual].respuesta) {
        feedback.textContent = "¡Correcto!";
        feedback.className = "mensaje-feedback correcto";

        const puntos = parseInt(localStorage.getItem("puntos")) || 1280;
        localStorage.setItem("puntos", puntos + 5);

        setTimeout(function () {
            if (actual < preguntasForo.length - 1) {
                actual++;
                mostrarPregunta();
            } else {
                alert("Terminaste todas las preguntas del foro, ¡buen trabajo!");
                window.location.href = "index.html";
            }
        }, 800);
    } else {
        feedback.textContent = "Intenta de nuevo";
        feedback.className = "mensaje-feedback incorrecto";
    }
};

btnAnterior.onclick = function () {
    if (actual > 0) {
        actual--;
        mostrarPregunta();
    }
};

entrada.addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
        btnSiguiente.click();
    }
});

mostrarPregunta();