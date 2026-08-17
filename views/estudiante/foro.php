<?php
$tituloPagina = 'EduLecto - Foro';
$hojasEstilo = ['estilos.css'];
$fuente = 'fredoka';
$paginaActiva = 'foro';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_estudiante.php';
?>

    <div class="pantalla-dividida con-nav">

        <div class="panel-cafe">
            <img src="img/buho.png" alt="Buho de EduLecto" onerror="this.style.display='none'">
            <h1>Responde las preguntas del foro.</h1>
        </div>

        <div class="panel-contenido">
            <div class="pregunta-foro">
                <h2>¿Cómo se escribe?</h2>
                <span class="dibujo" id="dibujo"></span>
            </div>

            <input type="text" class="entrada-respuesta" id="respuesta" placeholder="Escribe la respuesta...">
            <p class="mensaje-feedback" id="feedback"></p>

            <div class="fila-botones">
                <button class="boton" id="btnAnterior">Anterior</button>
                <button class="boton" id="btnSiguiente">Siguiente</button>
            </div>
        </div>

    </div>

    <script>
        window.EDULECTO_PREGUNTAS_FORO = <?= json_encode($preguntas, JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php
$scripts = ['foro.js'];
require BASE_PATH . '/views/layout/footer.php';
