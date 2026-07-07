const jugadores = [
    { nombre: "Ana", puntos: 2555 },
    { nombre: "Pablo", puntos: 2000 },
    { nombre: "Maria", puntos: 1700 }
];

const puntosUsuario = parseInt(localStorage.getItem("puntos")) || 1280;
jugadores.push({ nombre: "Ashley", puntos: puntosUsuario });

jugadores.sort(function (a, b) {
    return b.puntos - a.puntos;
});

const lista = document.getElementById("listaRanking");

jugadores.forEach(function (jugador, i) {
    const fila = document.createElement("div");
    fila.className = "fila-ranking";
    fila.innerHTML = "<span>" + jugador.nombre + " " + jugador.puntos + " puntos</span><span class='posicion'>" + (i + 1) + "</span>";
    lista.appendChild(fila);
});