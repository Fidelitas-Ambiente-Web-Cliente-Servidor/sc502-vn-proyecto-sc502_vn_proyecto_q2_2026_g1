const estudiante = {
    nombre: "Ashley",
    nivel: "Explorador",
    estrellas: 4,
    racha: 5,
    puntos: 1280
};

const progresoLectura = [
    { estado: "En proceso", cantidad: 8, color: "#4a90d9" },
    { estado: "Guardados", cantidad: 3, color: "#f5c518" },
    { estado: "Finalizadas", cantidad: 5, color: "#2f4f4f" }
];

function cargarPerfil() {
    const puntosGuardados = localStorage.getItem("puntos");
    if (puntosGuardados) {
        estudiante.puntos = parseInt(puntosGuardados);
    }

    document.getElementById("saludo").textContent = "Hola " + estudiante.nombre + "....";
    document.getElementById("nivelUsuario").textContent = estudiante.nivel;
    document.getElementById("racha").textContent = estudiante.racha;
    document.getElementById("puntos").textContent = estudiante.puntos;

    let estrellas = "";
    for (let i = 1; i <= 5; i++) {
        estrellas += i <= estudiante.estrellas ? "★" : "☆";
    }
    document.getElementById("estrellas").textContent = estrellas;

    const lista = document.getElementById("listaProgreso");
    progresoLectura.forEach(function (item) {
        const fila = document.createElement("div");
        fila.className = "fila-progreso";
        fila.innerHTML = '<span><span class="punto" style="background-color:' + item.color + '"></span>' + item.estado + '</span><span>' + item.cantidad + '</span>';
        lista.appendChild(fila);
    });
}

cargarPerfil();