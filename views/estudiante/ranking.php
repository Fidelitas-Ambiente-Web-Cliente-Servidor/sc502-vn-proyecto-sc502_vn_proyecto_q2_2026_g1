<?php
$tituloPagina = 'EduLecto - Ranking';
$hojasEstilo = ['estilos.css'];
$fuente = 'fredoka';
$paginaActiva = 'ranking';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_estudiante.php';
?>

    <p class="saludo">Hola <?= htmlspecialchars($_SESSION['nombre_completo']) ?>....</p>

    <div class="contenedor-ranking">
        <div class="tarjeta tarjeta-ranking">
            <h3>Ranking global <span>&#128200;</span></h3>
            <div id="listaRanking">
                <?php foreach ($jugadores as $i => $jugador): ?>
                <div class="fila-ranking<?= $jugador['id'] === $idEstudianteActual ? ' fila-actual' : '' ?>">
                    <span><?= htmlspecialchars($jugador['nombre']) ?> <?= (int) $jugador['puntos'] ?> puntos</span>
                    <span class="posicion"><?= $i + 1 ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <img src="img/buho.png" alt="Buho de EduLecto" class="buho-esquina" onerror="this.style.display='none'">

<?php
$scripts = [];
require BASE_PATH . '/views/layout/footer.php';
