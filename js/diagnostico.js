const preguntas = [
    { texto: "¿Cuál palabra esta bien escrita?", opciones: ["Baso", "Vaso", "Bazo"], correcta: 1 },
    { texto: "¿Cuál palabra esta bien escrita?", opciones: ["Havía", "Abía", "Había"], correcta: 2 },
    { texto: "Complete la oración: El sol ___ por el este.", opciones: ["sale", "zale", "sales"], correcta: 0 },
    { texto: "¿Cuál palabra lleva tilde?", opciones: ["arbol", "árbol", "arból"], correcta: 1 },
    { texto: "¿Cuál es el plural de lápiz?", opciones: ["lápizes", "lápises", "lápices"], correcta: 2 }
];

let actual = 0;
let respuestas = new Array(preguntas.length).fill(null);

const textoPregunta = document.getElementById("textoPregunta");
const contenedorOpciones = document.getElementById("opciones");
const btnAnterior = document.getElementById("btnAnterior");
const btnSiguiente = document.getElementById("btnSiguiente");

function mostrarPregunta() {
    const pregunta = preguntas[actual];
    textoPregunta.textContent = pregunta.texto;
    contenedorOpciones.innerHTML = "";

    pregunta.opciones.forEach(function (opcion, i) {
        const btn = document.createElement("button");
        btn.className = "boton boton-opcion";
        btn.textContent = opcion;
        if (respuestas[actual] === i) {
            btn.classList.add("seleccionada");
        }
        btn.onclick = function () {
            respuestas[actual] = i;
            mostrarPregunta();
        };
        contenedorOpciones.appendChild(btn);
    });

    btnSiguiente.textContent = actual === preguntas.length - 1 ? "Finalizar" : "Siguiente";
}

btnAnterior.onclick = function () {
    if (actual > 0) {
        actual--;
        mostrarPregunta();
    }
};

btnSiguiente.onclick = function () {
    if (respuestas[actual] === null) {
        alert("Seleccione una respuesta para continuar");
        return;
    }

    if (actual < preguntas.length - 1) {
        actual++;
        mostrarPregunta();
    } else {
        finalizarDiagnostico();
    }
};

function finalizarDiagnostico() {
    let aciertos = 0;
    for (let i = 0; i < preguntas.length; i++) {
        if (respuestas[i] === preguntas[i].correcta) {
            aciertos++;
        }
    }
    localStorage.setItem("aciertos", aciertos);
    localStorage.setItem("totalPreguntas", preguntas.length);
    window.location.href = "resultado.html";
}

mostrarPregunta();