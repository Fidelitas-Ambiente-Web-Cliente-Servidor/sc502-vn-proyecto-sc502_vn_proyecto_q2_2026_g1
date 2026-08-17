<?php
$tituloPagina = 'EduLecto - Perfil';
$hojasEstilo = ['estilos.css'];
$fuente = 'fredoka';
$paginaActiva = 'perfil';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_estudiante.php';
?>

    <p class="saludo" id="saludo">Hola <?= htmlspecialchars($estudiante['nombre_completo']) ?>....</p>

    <div class="contenido-perfil">

        <div class="columna-perfil">
            <div class="tarjeta tarjeta-estadisticas">
                <h3>Estadisticas <span>&#128200;</span></h3>
                <p>Nivel: <span id="nivelUsuario"><?= htmlspecialchars($nombreNivel) ?></span>
                    <span class="estrellas" id="estrellas"><?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $estrellas ? '★' : '☆';
                        }
                    ?></span>
                </p>
                <p>Racha: <span id="racha"><?= (int) $racha['racha_actual'] ?></span> días</p>
                <p>Puntos: <span id="puntos"><?= (int) $puntos ?></span></p>
                <p>Insignias:
                    <?php if (empty($insignias)): ?>
                        <span class="sin-insignias">Aún no tienes insignias</span>
                    <?php else: ?>
                        <?php foreach ($insignias as $insignia): ?>
                            <span class="insignia" title="<?= htmlspecialchars($insignia['nombre']) ?>">&#127942;</span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </p>
            </div>

            <div class="tarjeta tarjeta-progreso">
                <h3>Mi Progreso de Lectura <span>&#128200;</span></h3>
                <div id="listaProgreso">
                    <?php foreach ($progresoLectura as $item): ?>
                    <div class="fila-progreso">
                        <span><span class="punto" style="background-color:<?= htmlspecialchars($item['color']) ?>"></span><?= htmlspecialchars($item['estado']) ?></span>
                        <span><?= (int) $item['cantidad'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="lecciones">
            <h3>Continuar Lecciones</h3>
            <button class="boton boton-cafe" onclick="location.href='index.php?page=diagnostico'">&#128214; Lectura</button>
            <button class="boton boton-cafe" onclick="location.href='index.php?page=diagnostico'">&#9999;&#65039; Escritura</button>
            <button class="boton boton-cafe" onclick="location.href='index.php?page=foro'">&#127918; Juegos</button>
        </div>

    </div>

    <img src="img/buho.png" alt="Buho de EduLecto" class="buho-esquina" onerror="this.style.display='none'">

<?php
$scripts = [];
require BASE_PATH . '/views/layout/footer.php';
