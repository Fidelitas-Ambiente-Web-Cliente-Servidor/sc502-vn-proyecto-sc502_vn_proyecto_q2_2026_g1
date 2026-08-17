<?php

class ForoController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function index(): void
    {
        requerirSesion('estudiante');

        $stmt = $this->pdo->query("SELECT id_pregunta, dibujo_emoji FROM pregunta_foro WHERE estado = 'Activo' ORDER BY id_pregunta");
        $preguntas = $stmt->fetchAll();

        require BASE_PATH . '/views/estudiante/foro.php';
    }

    public function responder(): void
    {
        requerirSesion('estudiante');
        $idEstudiante = (int) $_SESSION['id_usuario'];
        $idPregunta = (int) ($_POST['id_pregunta'] ?? 0);
        $respuesta = trim($_POST['respuesta'] ?? '');

        $stmt = $this->pdo->prepare('SELECT respuesta_correcta FROM pregunta_foro WHERE id_pregunta = ?');
        $stmt->execute([$idPregunta]);
        $pregunta = $stmt->fetch();

        if (!$pregunta) {
            responderJson(['ok' => false, 'mensaje' => 'Pregunta no encontrada.'], 404);
        }

        $correcta = normalizarTexto($respuesta) === normalizarTexto($pregunta['respuesta_correcta']);

        $stmt = $this->pdo->prepare('INSERT INTO intento_foro (id_pregunta, id_estudiante, respuesta_dada, correcta) VALUES (?, ?, ?, ?)');
        $stmt->execute([$idPregunta, $idEstudiante, $respuesta, $correcta ? 1 : 0]);

        if ($correcta) {
            actualizarRacha($this->pdo, $idEstudiante);
        }

        responderJson(['ok' => true, 'correcta' => $correcta]);
    }
}
