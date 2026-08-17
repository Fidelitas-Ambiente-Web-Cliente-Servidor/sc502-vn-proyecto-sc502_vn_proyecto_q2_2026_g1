<?php
$tituloPagina = 'EduLecto - Clases';
$hojasEstilo = ['estilos.css', 'profesor.css'];
$fuente = 'fredoka';
$paginaActiva = 'clases';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_profesor.php';
?>

    <p class="saludo" id="saludo">Hola <?= htmlspecialchars($_SESSION['nombre_completo']) ?>....</p>

    <div class="contenido-profesor">

        <div id="vistaCalendario">

            <div class="pestanas">
                <button class="pestana futuras" data-filtro="futura">Futuras</button>
                <button class="pestana hoy" data-filtro="hoy">Para hoy</button>
                <button class="pestana pasadas" data-filtro="pasada">Pasadas</button>
            </div>

            <div class="calendario">
                <div class="calendario-cabecera">
                    <span class="numero-dia" style="font-size: 1.8rem;"><?= str_pad((string) date('j'), 2, '0', STR_PAD_LEFT) ?></span>
                    <span class="mes" id="mesActual"><?= htmlspecialchars($nombreMes) ?></span>
                    <span><?= (int) $anio ?></span>
                </div>
                <table class="tabla-calendario">
                    <thead>
                        <tr>
                            <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoCalendario"></tbody>
                </table>
            </div>

            <div class="tarjeta tarjeta-tabla" style="margin-top: 30px;">
                <span class="icono-tarjeta">&#128197;</span>
                <h3 style="margin-bottom: 15px;">Mis clases agendadas</h3>
                <table class="tabla-profesor">
                    <thead>
                        <tr>
                            <th>Tema</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estudiantes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoClases"></tbody>
                </table>
            </div>

            <div style="margin-top: 30px;">
                <button class="boton boton-accion" id="btnMostrarFormClase">Agendar nueva clase</button>
            </div>

        </div>

        <div id="vistaFormularioClase" class="tarjeta tarjeta-formulario" style="display: none;">
            <h3 id="tituloFormClase" style="margin-bottom: 15px;">Agendar nueva clase</h3>

            <input type="hidden" id="claseId" value="0">

            <div class="campo-formulario">
                <label for="temaClase">Tema de la clase *</label>
                <input type="text" id="temaClase" placeholder="Ej: Comprensión lectora">
            </div>

            <div class="campo-formulario">
                <label for="fechaClase">Fecha *</label>
                <input type="date" id="fechaClase">
            </div>

            <div class="campo-formulario">
                <label for="horaClase">Hora *</label>
                <input type="time" id="horaClase">
            </div>

            <div class="campo-formulario">
                <label>Asignar estudiantes</label>
                <div id="listaEstudiantesAsignar" class="lista-checks">
                    <?php foreach ($estudiantesDisponibles as $est): ?>
                    <label class="check-estudiante">
                        <input type="checkbox" class="chk-estudiante-clase" value="<?= (int) $est['id_usuario'] ?>">
                        <?= htmlspecialchars($est['nombre_completo']) ?> <span class="nivel-chip">Nivel <?= (int) $est['nivel_actual'] ?></span>
                    </label>
                    <?php endforeach; ?>
                    <?php if (empty($estudiantesDisponibles)): ?>
                    <p class="sin-insignias">Todavía no hay estudiantes registrados.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="fila-form-botones">
                <button class="boton" id="btnGuardarClase">&#128190; Guardar clase</button>
                <button class="boton-secundario" id="btnCancelarClase">Cancelar</button>
                <button class="boton-mini eliminar" id="btnEliminarClase" style="display:none;">Eliminar clase</button>
            </div>
        </div>

    </div>

    <img src="img/buho.png" alt="Buho de EduLecto" class="buho-esquina" onerror="this.style.display='none'">

    <script>
        window.EDULECTO_EVENTOS_CLASES = <?= json_encode($eventosPorDia, JSON_UNESCAPED_UNICODE) ?>;
        window.EDULECTO_DIAS_EN_MES = <?= (int) $diasEnMes ?>;
        window.EDULECTO_PRIMER_DIA_SEMANA = <?= (int) $primerDiaSemana ?>;
        window.EDULECTO_MIS_CLASES = <?= json_encode($misClases, JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php
$scripts = ['profesor-clases.js'];
require BASE_PATH . '/views/layout/footer.php';
