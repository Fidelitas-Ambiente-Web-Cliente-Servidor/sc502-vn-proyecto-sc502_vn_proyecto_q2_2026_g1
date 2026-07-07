const aciertos = parseInt(localStorage.getItem("aciertos")) || 0;
const total = parseInt(localStorage.getItem("totalPreguntas")) || 5;

const porcentaje = Math.round((aciertos / total) * 100);

let nivel;
let mensaje;

if (porcentaje < 40) {
    nivel = 1;
    mensaje = "Tu nivel de comprension de lectura es inicial.";
} else if (porcentaje < 60) {
    nivel = 2;
    mensaje = "Tu nivel de comprension de lectura es basico.";
} else if (porcentaje < 80) {
    nivel = 3;
    mensaje = "Tu nivel de comprension de lectura es bueno.";
} else {
    nivel = 4;
    mensaje = "Tu nivel de comprension de lectura es excelente.";
}

document.getElementById("tituloNivel").textContent = "Nivel " + nivel;
document.getElementById("mensajeNivel").textContent = mensaje;
document.getElementById("porcentaje").textContent = porcentaje + "%";

setTimeout(function () {
    document.getElementById("relleno").style.width = porcentaje + "%";
}, 200);

const puntosActuales = parseInt(localStorage.getItem("puntos")) || 1280;
if (!localStorage.getItem("diagnosticoHecho")) {
    localStorage.setItem("puntos", puntosActuales + aciertos * 10);
    localStorage.setItem("diagnosticoHecho", "si");
}