<?php
$tituloPagina = 'EduLecto - Editar Foro';
$hojasEstilo = ['estilos.css', 'profesor.css'];
$fuente = 'fredoka';
$paginaActiva = 'foro';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_profesor.php';
?>

    <div class="pantalla-dividida con-nav">

        <div class="panel-cafe">
            <img src="img/buho.png" alt="Buho de EduLecto" onerror="this.style.display='none'">
            <h1>Editar foro</h1>
        </div>

        <div class="panel-contenido">
            <div class="pregunta-foro">
                <h2 id="preguntaTexto">¿Cómo se escribe?</h2>
                <span class="dibujo" id="dibujo"></span>
            </div>

            <div class="campo-formulario" id="campoDibujoNuevo" style="display:none;">
                <label for="dibujoNuevo">Emoji o dibujo de la nueva pregunta</label>
                <input type="text" class="entrada-respuesta" id="dibujoNuevo" placeholder="Ej: 🐘">
            </div>

            <input type="text" class="entrada-respuesta" id="respuesta" placeholder="Escribe la respuesta...">
            <p class="contador-foro" id="contador"></p>

            <div class="fila-botones">
                <button class="boton" id="btnAnterior">Anterior</button>
                <button class="boton" id="btnAgregar">Agregar</button>
            </div>
        </div>

    </div>

    <script>
        window.EDULECTO_PREGUNTAS_FORO_PROFESOR = <?= json_encode($preguntas, JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php
$scripts = ['profesor-foro.js'];
require BASE_PATH . '/views/layout/footer.php';
