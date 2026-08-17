<?php
$tituloPagina = 'EduLecto - Estudiantes';
$hojasEstilo = ['estilos.css', 'profesor.css'];
$fuente = 'fredoka';
$paginaActiva = 'estudiantes';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_profesor.php';
?>

    <p class="saludo" id="saludo">Hola <?= htmlspecialchars($_SESSION['nombre_completo']) ?>....</p>

    <div class="contenido-profesor">

        <div class="tarjeta tarjeta-tabla">
            <span class="icono-tarjeta">&#128100;</span>
            <h3 style="margin-bottom: 15px;">Gestión estudiantes</h3>
            <table class="tabla-profesor">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Nivel</th>
                        <th>Progreso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cuerpoEstudiantes"></tbody>
            </table>
        </div>

        <div style="margin-top: 30px;">
            <button class="boton boton-accion" onclick="location.href='index.php?page=profesor-ejercicios#crear'">Crear nueva actividad</button>
        </div>

    </div>

    <img src="img/buho.png" alt="Buho de EduLecto" class="buho-esquina" onerror="this.style.display='none'">

    <script>
        window.EDULECTO_ESTUDIANTES = <?= json_encode($estudiantes, JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php
$scripts = ['profesor-estudiantes.js'];
require BASE_PATH . '/views/layout/footer.php';
