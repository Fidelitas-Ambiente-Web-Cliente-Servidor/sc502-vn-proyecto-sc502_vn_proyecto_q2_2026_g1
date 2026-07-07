// Lista de estudiantes (datos simulados, listos para conectarse al backend PHP)
const estudiantes = [
    { nombre: "Pablo", edad: 10, nivel: 3, progreso: 75 },
    { nombre: "Maria", edad: 11, nivel: 4, progreso: 65 },
    { nombre: "Paula", edad: 12, nivel: 5, progreso: 45 }
];

const cuerpoEstudiantes = document.getElementById("cuerpoEstudiantes");

function renderEstudiantes() {
    cuerpoEstudiantes.innerHTML = "";

    estudiantes.forEach(function (est, indice) {
        const fila = document.createElement("tr");
        fila.innerHTML =
            "<td>" + est.nombre + "</td>" +
            "<td>" + est.edad + " años</td>" +
            "<td>" + est.nivel + "</td>" +
            "<td class=\"celda-progreso\">" +
                "<div class=\"etiqueta-barra\"><span></span><span>" + est.progreso + "%</span></div>" +
                "<div class=\"barra\"><div class=\"barra-relleno\" style=\"width:" + est.progreso + "%\"></div></div>" +
            "</td>" +
            "<td><button class=\"boton-mini\" data-indice=\"" + indice + "\">Ver detalles</button></td>";
        cuerpoEstudiantes.appendChild(fila);
    });

    document.querySelectorAll(".boton-mini").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const est = estudiantes[this.dataset.indice];
            alert("Detalle de " + est.nombre + ": nivel " + est.nivel + ", progreso " + est.progreso + "%");
        });
    });
}

renderEstudiantes();