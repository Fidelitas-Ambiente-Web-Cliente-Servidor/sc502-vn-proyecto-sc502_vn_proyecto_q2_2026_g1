<?php
$tituloPagina = 'EduLecto - Resultado';
$hojasEstilo = ['estilos.css'];
$fuente = 'fredoka';
require BASE_PATH . '/views/layout/header.php';
?>

    <div class="pantalla-dividida">

        <div class="panel-cafe">
            <img src="img/buho.png" alt="Buho de EduLecto" onerror="this.style.display='none'">
            <h1>Excelente, haz finalizado el diagnostico.</h1>
        </div>

        <div class="panel-contenido">
            <h2>Nivel Obtenido</h2>

            <div class="tarjeta tarjeta-resultado">
                <h3 id="tituloNivel">Nivel <?= (int) $nivel ?></h3>
                <p id="mensajeNivel"><?= htmlspecialchars($mensaje) ?></p>
                <div class="etiqueta-barra">
                    <span>Aciertos</span>
                    <span id="porcentaje"><?= (int) $porcentaje ?>%</span>
                </div>
                <div class="barra">
                    <div class="barra-relleno" id="relleno" style="width:0%"></div>
                </div>
            </div>

            <button class="boton" onclick="location.href='index.php?page=perfil'">Ir a mi perfil</button>
        </div>

    </div>

    <script>
        window.EDULECTO_PORCENTAJE = <?= (float) $porcentaje ?>;
    </script>
<?php
$scripts = ['resultados.js'];
require BASE_PATH . '/views/layout/footer.php';
