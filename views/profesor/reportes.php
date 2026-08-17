<?php
$tituloPagina = 'EduLecto - Reportes';
$hojasEstilo = ['estilos.css', 'profesor.css'];
$fuente = 'fredoka';
$paginaActiva = 'reportes';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_profesor.php';
?>

    <p class="saludo" id="saludo">Hola <?= htmlspecialchars($_SESSION['nombre_completo']) ?>....</p>

    <div class="contenido-profesor">

        <div class="fila-acciones" style="align-items: flex-start; justify-content: space-between; flex-wrap: wrap;">

            <div class="tarjeta tarjeta-estadisticas" style="width: 380px;">
                <h3>Estadisticas <span>&#128200;</span></h3>
                <div class="fila-progreso">
                    <span>Numero de estudiantes</span>
                    <span id="numEstudiantes"><?= (int) $numEstudiantes ?></span>
                </div>
                <div class="fila-progreso">
                    <span>Promedio</span>
                    <span id="promedio"><?= (int) $promedio ?></span>
                </div>
                <div class="etiqueta-barra">
                    <span>Progreso</span>
                    <span id="progresoTexto"><?= (int) $progreso ?>%</span>
                </div>
                <div class="barra" style="margin-bottom: 18px;">
                    <div class="barra-relleno" id="progresoBarra" style="width: <?= (int) $progreso ?>%;"></div>
                </div>
                <div class="fila-progreso">
                    <span>Lecciones Pendientes</span>
                    <span id="leccionesPendientes"><?= (int) $leccionesPendientes ?></span>
                </div>
            </div>

            <div class="fila-acciones" style="flex-direction: column;">
                <button class="boton boton-accion" onclick="location.href='index.php?page=profesor-ejercicios#crear'">Crear nueva actividad</button>
                <button class="boton boton-accion" onclick="location.href='index.php?page=profesor-estudiantes'">Asignar actividades</button>
            </div>

        </div>

    </div>

    <img src="img/buho.png" alt="Buho de EduLecto" class="buho-esquina" onerror="this.style.display='none'">

<?php
$scripts = [];
require BASE_PATH . '/views/layout/footer.php';
