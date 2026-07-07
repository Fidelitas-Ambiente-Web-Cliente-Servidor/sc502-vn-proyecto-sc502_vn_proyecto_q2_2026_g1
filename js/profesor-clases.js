// Calendario de clases de junio 2025 (datos simulados, listos para conectarse al backend PHP)
// El día 1 de junio de 2025 cae domingo.
const eventosClases = {
    2: { texto: "Escritura", tipo: "pasada" },
    18: { texto: "Lectura", tipo: "hoy" },
    26: { texto: "Escritura", tipo: "futura" }
};

const claseTipo = {
    futura: "escritura-futura",
    hoy: "lectura-hoy",
    pasada: "escritura-pasada"
};

const cuerpoCalendario = document.getElementById("cuerpoCalendario");
const pestanas = document.querySelectorAll(".pestana");
let filtroActivo = null; // null = mostrar todas las clases

function construirCalendario() {
    cuerpoCalendario.innerHTML = "";
    const diasEnMes = 30;
    const primerDiaSemana = 0; // domingo
    let diaActual = 1;

    for (let fila = 0; fila < 5 && diaActual <= diasEnMes; fila++) {
        const tr = document.createElement("tr");

        for (let col = 0; col < 7; col++) {
            const td = document.createElement("td");

            if ((fila === 0 && col < primerDiaSemana) || diaActual > diasEnMes) {
                tr.appendChild(td);
                continue;
            }

            const evento = eventosClases[diaActual];
            let html = "<span class=\"numero-dia\">" + diaActual + "</span>";

            if (evento) {
                const visible = (filtroActivo === null || filtroActivo === evento.tipo);
                html += "<span class=\"evento " + claseTipo[evento.tipo] + "\" style=\"" +
                    (visible ? "" : "display:none;") + "\">" + evento.texto + "</span>";
            }

            td.innerHTML = html;
            tr.appendChild(td);
            diaActual++;
        }

        cuerpoCalendario.appendChild(tr);
    }
}

pestanas.forEach(function (btn) {
    btn.addEventListener("click", function () {
        pestanas.forEach(function (p) { p.classList.add("atenuada"); });
        this.classList.remove("atenuada");
        filtroActivo = this.dataset.filtro;
        construirCalendario();
    });
});

construirCalendario();