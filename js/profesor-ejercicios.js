// Lista de ejercicios (datos simulados, listos para conectarse al backend PHP)
let ejercicios = [
    { nombre: "Crucigrama", nivel: 3 },
    { nombre: "Ordenar Palabras", nivel: 4 },
    { nombre: "Sopa Letras", nivel: 5 }
];

const cuerpoEjercicios = document.getElementById("cuerpoEjercicios");
const vistaListado = document.getElementById("vistaListado");
const vistaFormulario = document.getElementById("vistaFormulario");
const btnMostrarForm = document.getElementById("btnMostrarForm");
const btnCancelarActividad = document.getElementById("btnCancelarActividad");
const btnAgregarActividad = document.getElementById("btnAgregarActividad");
const nombreActividad = document.getElementById("nombreActividad");
const descripcionActividad = document.getElementById("descripcionActividad");
const estadoActividad = document.getElementById("estadoActividad");

function renderEjercicios() {
    cuerpoEjercicios.innerHTML = "";

    ejercicios.forEach(function (ej, indice) {
        const fila = document.createElement("tr");
        fila.innerHTML =
            "<td class=\"nombre-ejercicio\">" + ej.nombre + "</td>" +
            "<td><button class=\"boton-mini\" data-accion=\"editar\" data-indice=\"" + indice + "\">Editar</button></td>" +
            "<td>" + ej.nivel + "</td>" +
            "<td><button class=\"boton-mini\" data-accion=\"guardar\" data-indice=\"" + indice + "\">Guardar</button></td>" +
            "<td><button class=\"boton-mini eliminar\" data-accion=\"eliminar\" data-indice=\"" + indice + "\">Eliminar</button></td>";
        cuerpoEjercicios.appendChild(fila);
    });

    cuerpoEjercicios.querySelectorAll("button").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const indice = Number(this.dataset.indice);
            const accion = this.dataset.accion;
            const celdaNombre = this.closest("tr").querySelector(".nombre-ejercicio");

            if (accion === "editar") {
                celdaNombre.contentEditable = "true";
                celdaNombre.focus();
            } else if (accion === "guardar") {
                celdaNombre.contentEditable = "false";
                ejercicios[indice].nombre = celdaNombre.textContent.trim();
            } else if (accion === "eliminar") {
                ejercicios.splice(indice, 1);
                renderEjercicios();
            }
        });
    });
}

function mostrarFormulario() {
    vistaListado.style.display = "none";
    vistaFormulario.style.display = "block";
    nombreActividad.value = "";
    descripcionActividad.value = "";
    estadoActividad.value = "Activo";
    nombreActividad.focus();
}

function mostrarListado() {
    vistaFormulario.style.display = "none";
    vistaListado.style.display = "block";
}

btnMostrarForm.addEventListener("click", mostrarFormulario);
btnCancelarActividad.addEventListener("click", mostrarListado);

btnAgregarActividad.addEventListener("click", function () {
    if (nombreActividad.value.trim() === "" || descripcionActividad.value.trim() === "") {
        alert("Completa el nombre y la descripción de la actividad.");
        return;
    }

    ejercicios.push({ nombre: nombreActividad.value.trim(), nivel: 1 });
    renderEjercicios();
    mostrarListado();
});

if (window.location.hash === "#crear") {
    mostrarFormulario();
}

renderEjercicios();