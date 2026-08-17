<?php
$tituloPagina = 'EduLecto - Diagnostico';
$hojasEstilo = ['estilos.css'];
$fuente = 'fredoka';
require BASE_PATH . '/views/layout/header.php';
?>

    <div class="pantalla-dividida">

        <div class="panel-cafe">
            <img src="img/buho.png" alt="Buho de EduLecto" onerror="this.style.display='none'">
            <h1>Diagnostico Inicial.<br><br>Responda las preguntas</h1>
        </div>

        <div class="panel-contenido">
            <h2 id="textoPregunta"></h2>
            <div id="opciones" style="display:flex; flex-direction:column; gap:18px;"></div>

            <div class="fila-botones">
                <button class="boton" id="btnAnterior">Anterior</button>
                <button class="boton" id="btnSiguiente">Siguiente</button>
            </div>
        </div>

    </div>

    <script>
        window.EDULECTO_PREGUNTAS = <?= json_encode($preguntas, JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php
$scripts = ['diagnostico.js'];
require BASE_PATH . '/views/layout/footer.php';
