// Estadísticas del profesor (datos simulados, listos para conectarse al backend PHP)
const estadisticasProfesor = {
    numEstudiantes: 25,
    promedio: 90,
    progreso: 75,
    leccionesPendientes: 7
};

document.getElementById("numEstudiantes").textContent = estadisticasProfesor.numEstudiantes;
document.getElementById("promedio").textContent = estadisticasProfesor.promedio;
document.getElementById("progresoTexto").textContent = estadisticasProfesor.progreso + "%";
document.getElementById("progresoBarra").style.width = estadisticasProfesor.progreso + "%";
document.getElementById("leccionesPendientes").textContent = estadisticasProfesor.leccionesPendientes;
