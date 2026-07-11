const correctas = localStorage.getItem("juegoCorrectas") || "20";
const incorrectas = localStorage.getItem("juegoIncorrectas") || "3";

document.getElementById("correctas").textContent = correctas;
document.getElementById("incorrectas").textContent = incorrectas;