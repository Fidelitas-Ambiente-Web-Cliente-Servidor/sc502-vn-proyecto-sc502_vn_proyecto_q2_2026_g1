<?php
$tituloPagina = 'EduLecto - Ejercicios';
$hojasEstilo = ['estilos.css', 'profesor.css'];
$fuente = 'fredoka';
$paginaActiva = 'ejercicios';
require BASE_PATH . '/views/layout/header.php';
require BASE_PATH . '/views/layout/nav_profesor.php';
?>

    <p class="saludo" id="saludo">Hola <?= htmlspecialchars($_SESSION['nombre_completo']) ?>....</p>

    <div class="contenido-profesor">

        <div id="vistaListado">
            <div class="tarjeta tarjeta-tabla">
                <span class="icono-tarjeta">&#128100;</span>
                <h3 style="margin-bottom: 15px;">Ejercicios</h3>
                <table class="tabla-profesor">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Editar</th>
                            <th>Nivel</th>
                            <th>Guardar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoEjercicios"></tbody>
                </table>
            </div>

            <div style="margin-top: 30px;">
                <button class="boton boton-accion" id="btnMostrarForm">Crear nueva actividad</button>
            </div>
        </div>

        <div id="vistaFormulario" class="tarjeta tarjeta-formulario" style="display: none;">
            <div class="campo-formulario">
                <label for="nombreActividad">Nombre de la actividad</label>
                <input type="text" id="nombreActividad" placeholder="Ej: Crucigrama">
            </div>

            <div class="campo-formulario">
                <label for="descripcionActividad">Descripción de la actividad *</label>
                <textarea id="descripcionActividad" placeholder="Describa las responsabilidades y tareas principales del puesto..."></textarea>
            </div>

            <div class="campo-formulario">
                <label for="tipoActividad">Tipo *</label>
                <select id="tipoActividad">
                    <option value="crucigrama">Crucigrama</option>
                    <option value="ordenar_palabras">Ordenar palabras</option>
                    <option value="sopa_letras">Sopa de letras</option>
                    <option value="adivinanza">Adivinanza</option>
                </select>
            </div>

            <div class="campo-formulario">
                <label for="nivelActividad">Nivel *</label>
                <input type="number" id="nivelActividad" min="1" max="10" value="1">
            </div>

            <div class="campo-formulario">
                <label for="estadoActividad">Estado *</label>
                <select id="estadoActividad">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <div class="fila-form-botones">
                <button class="boton" id="btnAgregarActividad">&#128190; Agregar actividad</button>
                <button class="boton-secundario" id="btnCancelarActividad">Cancelar</button>
            </div>
        </div>

    </div>

    <img src="img/buho.png" alt="Buho de EduLecto" class="buho-esquina" onerror="this.style.display='none'">

    <script>
        window.EDULECTO_EJERCICIOS = <?= json_encode($ejercicios, JSON_UNESCAPED_UNICODE) ?>;
    </script>
<?php
$scripts = ['profesor-ejercicios.js'];
require BASE_PATH . '/views/layout/footer.php';
