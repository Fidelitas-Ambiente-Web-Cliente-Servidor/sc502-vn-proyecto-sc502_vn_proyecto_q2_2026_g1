<?php

class ProfesorController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function clases(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $anio = (int) date('Y');
        $mes = (int) date('n');
        $nombreMes = strtoupper(date('F', mktime(0, 0, 0, $mes, 1, $anio)));

        $stmt = $this->pdo->prepare(
            'SELECT id_clase, tema, fecha, hora, estado
             FROM clase
             WHERE id_docente = ? AND YEAR(fecha) = ? AND MONTH(fecha) = ?
             ORDER BY fecha'
        );
        $stmt->execute([$idDocente, $anio, $mes]);
        $clasesDelMes = $stmt->fetchAll();

        $eventosPorDia = [];
        foreach ($clasesDelMes as $clase) {
            $dia = (int) date('j', strtotime($clase['fecha']));
            $eventosPorDia[$dia] = [
                'texto' => $clase['tema'],
                'tipo' => $clase['estado'],
            ];
        }

        $diasEnMes = (int) date('t', mktime(0, 0, 0, $mes, 1, $anio));
        $primerDiaSemana = (int) date('w', mktime(0, 0, 0, $mes, 1, $anio));

        $stmt = $this->pdo->prepare(
            'SELECT c.id_clase, c.tema, c.fecha, c.hora, c.estado, COUNT(ce.id_estudiante) AS total_estudiantes
             FROM clase c
             LEFT JOIN clase_estudiante ce ON ce.id_clase = c.id_clase
             WHERE c.id_docente = ?
             GROUP BY c.id_clase, c.tema, c.fecha, c.hora, c.estado
             ORDER BY c.fecha DESC, c.hora DESC'
        );
        $stmt->execute([$idDocente]);
        $misClases = $stmt->fetchAll();

        $stmt = $this->pdo->query(
            'SELECT u.id_usuario, u.nombre_completo, e.nivel_actual
             FROM usuario u
             INNER JOIN estudiante e ON e.id_estudiante = u.id_usuario
             WHERE u.activo = 1
             ORDER BY u.nombre_completo'
        );
        $estudiantesDisponibles = $stmt->fetchAll();

        require BASE_PATH . '/views/profesor/clases.php';
    }

    public function crearClase(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $tema = trim($_POST['tema'] ?? '');
        $fecha = trim($_POST['fecha'] ?? '');
        $hora = trim($_POST['hora'] ?? '');
        $estudiantes = json_decode($_POST['estudiantes'] ?? '[]', true);

        if ($tema === '' || $fecha === '' || $hora === '') {
            responderJson(['ok' => false, 'mensaje' => 'Completa el tema, la fecha y la hora de la clase.'], 422);
        }

        if (!is_array($estudiantes)) {
            $estudiantes = [];
        }

        $estado = $this->calcularEstadoClase($fecha);

        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('INSERT INTO clase (id_docente, tema, fecha, hora, estado) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$idDocente, $tema, $fecha, $hora, $estado]);
            $idClase = (int) $this->pdo->lastInsertId();

            $stmtAsignar = $this->pdo->prepare('INSERT IGNORE INTO clase_estudiante (id_clase, id_estudiante) VALUES (?, ?)');
            foreach ($estudiantes as $idEstudiante) {
                $stmtAsignar->execute([$idClase, (int) $idEstudiante]);
            }

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            responderJson(['ok' => false, 'mensaje' => 'No se pudo agendar la clase.'], 500);
        }

        responderJson(['ok' => true, 'id' => $idClase]);
    }

    public function obtenerClase(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];
        $idClase = (int) ($_GET['id'] ?? 0);

        $stmt = $this->pdo->prepare('SELECT id_clase, tema, fecha, hora, estado FROM clase WHERE id_clase = ? AND id_docente = ?');
        $stmt->execute([$idClase, $idDocente]);
        $clase = $stmt->fetch();

        if (!$clase) {
            responderJson(['ok' => false, 'mensaje' => 'Clase no encontrada.'], 404);
        }

        $stmt = $this->pdo->prepare('SELECT id_estudiante FROM clase_estudiante WHERE id_clase = ?');
        $stmt->execute([$idClase]);
        $asignados = array_map('intval', array_column($stmt->fetchAll(), 'id_estudiante'));

        responderJson(['ok' => true, 'clase' => $clase, 'estudiantes' => $asignados]);
    }

    public function actualizarClase(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];
        $idClase = (int) ($_POST['id'] ?? 0);

        $tema = trim($_POST['tema'] ?? '');
        $fecha = trim($_POST['fecha'] ?? '');
        $hora = trim($_POST['hora'] ?? '');
        $estudiantes = json_decode($_POST['estudiantes'] ?? '[]', true);

        if ($tema === '' || $fecha === '' || $hora === '') {
            responderJson(['ok' => false, 'mensaje' => 'Completa el tema, la fecha y la hora de la clase.'], 422);
        }

        if (!is_array($estudiantes)) {
            $estudiantes = [];
        }

        $stmt = $this->pdo->prepare('SELECT id_clase FROM clase WHERE id_clase = ? AND id_docente = ?');
        $stmt->execute([$idClase, $idDocente]);
        if (!$stmt->fetch()) {
            responderJson(['ok' => false, 'mensaje' => 'Clase no encontrada.'], 404);
        }

        $estado = $this->calcularEstadoClase($fecha);

        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('UPDATE clase SET tema = ?, fecha = ?, hora = ?, estado = ? WHERE id_clase = ? AND id_docente = ?');
            $stmt->execute([$tema, $fecha, $hora, $estado, $idClase, $idDocente]);

            $stmt = $this->pdo->prepare('DELETE FROM clase_estudiante WHERE id_clase = ?');
            $stmt->execute([$idClase]);

            $stmtAsignar = $this->pdo->prepare('INSERT IGNORE INTO clase_estudiante (id_clase, id_estudiante) VALUES (?, ?)');
            foreach ($estudiantes as $idEstudiante) {
                $stmtAsignar->execute([$idClase, (int) $idEstudiante]);
            }

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            responderJson(['ok' => false, 'mensaje' => 'No se pudo actualizar la clase.'], 500);
        }

        responderJson(['ok' => true]);
    }

    public function eliminarClase(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];
        $idClase = (int) ($_POST['id'] ?? 0);

        $stmt = $this->pdo->prepare('DELETE FROM clase WHERE id_clase = ? AND id_docente = ?');
        $stmt->execute([$idClase, $idDocente]);

        responderJson(['ok' => true]);
    }

    private function calcularEstadoClase(string $fecha): string
    {
        $hoy = date('Y-m-d');
        if ($fecha === $hoy) {
            return 'hoy';
        }
        return $fecha < $hoy ? 'pasada' : 'futura';
    }

    public function estudiantes(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $stmt = $this->pdo->prepare(
            'SELECT DISTINCT u.id_usuario, u.nombre_completo, e.edad, e.nivel_actual
             FROM usuario u
             INNER JOIN estudiante e ON e.id_estudiante = u.id_usuario
             INNER JOIN clase_estudiante ce ON ce.id_estudiante = e.id_estudiante
             INNER JOIN clase c ON c.id_clase = ce.id_clase
             WHERE c.id_docente = ?
             ORDER BY u.nombre_completo'
        );
        $stmt->execute([$idDocente]);
        $filas = $stmt->fetchAll();

        $estudiantes = [];
        foreach ($filas as $fila) {
            $stmt2 = $this->pdo->prepare('SELECT COALESCE(AVG(puntaje), 0) AS promedio FROM progreso_actividad WHERE id_estudiante = ?');
            $stmt2->execute([$fila['id_usuario']]);
            $progreso = round((float) $stmt2->fetch()['promedio']);

            $estudiantes[] = [
                'id' => (int) $fila['id_usuario'],
                'nombre' => $fila['nombre_completo'],
                'edad' => (int) $fila['edad'],
                'nivel' => (int) $fila['nivel_actual'],
                'progreso' => (int) $progreso,
            ];
        }

        require BASE_PATH . '/views/profesor/estudiantes.php';
    }

    public function ejercicios(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $stmt = $this->pdo->prepare('SELECT id_actividad, nombre, descripcion, tipo, nivel, estado FROM actividad WHERE id_docente_creador = ? ORDER BY fecha_creacion DESC');
        $stmt->execute([$idDocente]);
        $ejercicios = $stmt->fetchAll();

        require BASE_PATH . '/views/profesor/ejercicios.php';
    }

    public function crearEjercicio(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $estado = $_POST['estado'] ?? 'Activo';
        $tipo = $_POST['tipo'] ?? 'crucigrama';
        $nivel = (int) ($_POST['nivel'] ?? 1);

        if ($nombre === '' || $descripcion === '') {
            responderJson(['ok' => false, 'mensaje' => 'Completa el nombre y la descripción de la actividad.'], 422);
        }

        if (!in_array($tipo, ['crucigrama', 'ordenar_palabras', 'sopa_letras', 'adivinanza'], true)) {
            $tipo = 'crucigrama';
        }
        if (!in_array($estado, ['Activo', 'Inactivo'], true)) {
            $estado = 'Activo';
        }
        $nivel = max(1, min(255, $nivel));

        $stmt = $this->pdo->prepare('INSERT INTO actividad (nombre, descripcion, tipo, nivel, estado, id_docente_creador) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nombre, $descripcion, $tipo, $nivel, $estado, $idDocente]);

        responderJson(['ok' => true, 'id' => (int) $this->pdo->lastInsertId()]);
    }

    public function actualizarEjercicio(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];
        $id = (int) ($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');

        if ($nombre === '') {
            responderJson(['ok' => false, 'mensaje' => 'El nombre no puede estar vacío.'], 422);
        }

        $stmt = $this->pdo->prepare('UPDATE actividad SET nombre = ? WHERE id_actividad = ? AND id_docente_creador = ?');
        $stmt->execute([$nombre, $id, $idDocente]);

        responderJson(['ok' => true]);
    }

    public function eliminarEjercicio(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];
        $id = (int) ($_POST['id'] ?? 0);

        $stmt = $this->pdo->prepare('DELETE FROM actividad WHERE id_actividad = ? AND id_docente_creador = ?');
        $stmt->execute([$id, $idDocente]);

        responderJson(['ok' => true]);
    }

    public function foro(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $stmt = $this->pdo->prepare('SELECT id_pregunta, dibujo_emoji, respuesta_correcta FROM pregunta_foro WHERE id_docente_creador = ? ORDER BY id_pregunta');
        $stmt->execute([$idDocente]);
        $preguntas = $stmt->fetchAll();

        require BASE_PATH . '/views/profesor/foro.php';
    }

    public function guardarPreguntaForo(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $id = (int) ($_POST['id'] ?? 0);
        $dibujo = trim($_POST['dibujo'] ?? '');
        $respuesta = trim(mb_strtolower($_POST['respuesta'] ?? ''));

        if ($respuesta === '') {
            responderJson(['ok' => false, 'mensaje' => 'Escribe la respuesta correcta antes de agregar.'], 422);
        }

        if ($id > 0) {
            $stmt = $this->pdo->prepare('UPDATE pregunta_foro SET respuesta_correcta = ? WHERE id_pregunta = ? AND id_docente_creador = ?');
            $stmt->execute([$respuesta, $id, $idDocente]);
            responderJson(['ok' => true, 'id' => $id]);
        }

        if ($dibujo === '') {
            responderJson(['ok' => false, 'mensaje' => 'Ingresa el emoji o dibujo de la pregunta.'], 422);
        }

        $stmt = $this->pdo->prepare('INSERT INTO pregunta_foro (dibujo_emoji, respuesta_correcta, id_docente_creador) VALUES (?, ?, ?)');
        $stmt->execute([$dibujo, $respuesta, $idDocente]);

        responderJson(['ok' => true, 'id' => (int) $this->pdo->lastInsertId()]);
    }

    public function reportes(): void
    {
        requerirSesion('docente');
        $idDocente = (int) $_SESSION['id_usuario'];

        $stmt = $this->pdo->prepare(
            'SELECT COUNT(DISTINCT ce.id_estudiante) AS total
             FROM clase_estudiante ce
             INNER JOIN clase c ON c.id_clase = ce.id_clase
             WHERE c.id_docente = ?'
        );
        $stmt->execute([$idDocente]);
        $numEstudiantes = (int) $stmt->fetch()['total'];

        $stmt = $this->pdo->prepare(
            'SELECT COALESCE(AVG(pa.puntaje), 0) AS promedio
             FROM progreso_actividad pa
             INNER JOIN actividad a ON a.id_actividad = pa.id_actividad
             WHERE a.id_docente_creador = ?'
        );
        $stmt->execute([$idDocente]);
        $promedio = (int) round((float) $stmt->fetch()['promedio']);

        $stmt = $this->pdo->prepare(
            'SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN pa.completado = 1 THEN 1 ELSE 0 END) AS completadas
             FROM progreso_actividad pa
             INNER JOIN actividad a ON a.id_actividad = pa.id_actividad
             WHERE a.id_docente_creador = ?'
        );
        $stmt->execute([$idDocente]);
        $fila = $stmt->fetch();
        $totalProgreso = (int) $fila['total'];
        $completadas = (int) $fila['completadas'];
        $progreso = $totalProgreso > 0 ? (int) round(($completadas / $totalProgreso) * 100) : 0;
        $leccionesPendientes = $totalProgreso - $completadas;

        require BASE_PATH . '/views/profesor/reportes.php';
    }
}
