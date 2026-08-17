<?php

class DiagnosticoController
{
    private PDO $pdo;

    private const PREGUNTAS = [
        ['texto' => '¿Cuál palabra esta bien escrita?', 'opciones' => ['Baso', 'Vaso', 'Bazo'], 'correcta' => 1],
        ['texto' => '¿Cuál palabra esta bien escrita?', 'opciones' => ['Havía', 'Abía', 'Había'], 'correcta' => 2],
        ['texto' => 'Complete la oración: El sol ___ por el este.', 'opciones' => ['sale', 'zale', 'sales'], 'correcta' => 0],
        ['texto' => '¿Cuál palabra lleva tilde?', 'opciones' => ['arbol', 'árbol', 'arból'], 'correcta' => 1],
        ['texto' => '¿Cuál es el plural de lápiz?', 'opciones' => ['lápizes', 'lápises', 'lápices'], 'correcta' => 2],
    ];

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function index(): void
    {
        requerirSesion('estudiante');
        $preguntas = array_map(function ($p) {
            return ['texto' => $p['texto'], 'opciones' => $p['opciones']];
        }, self::PREGUNTAS);
        require BASE_PATH . '/views/estudiante/diagnostico.php';
    }

    public function finalizar(): void
    {
        requerirSesion('estudiante');
        $idEstudiante = (int) $_SESSION['id_usuario'];

        $respuestas = json_decode($_POST['respuestas'] ?? '[]', true);
        if (!is_array($respuestas)) {
            responderJson(['ok' => false, 'mensaje' => 'Respuestas inválidas.'], 422);
        }

        $total = count(self::PREGUNTAS);
        $aciertos = 0;
        foreach (self::PREGUNTAS as $i => $pregunta) {
            if (isset($respuestas[$i]) && (int) $respuestas[$i] === $pregunta['correcta']) {
                $aciertos++;
            }
        }

        $porcentaje = $total > 0 ? round(($aciertos / $total) * 100, 2) : 0;

        if ($porcentaje < 40) {
            $nivel = 1;
            $mensaje = 'Tu nivel de comprension de lectura es inicial.';
        } elseif ($porcentaje < 60) {
            $nivel = 2;
            $mensaje = 'Tu nivel de comprension de lectura es basico.';
        } elseif ($porcentaje < 80) {
            $nivel = 3;
            $mensaje = 'Tu nivel de comprension de lectura es bueno.';
        } else {
            $nivel = 4;
            $mensaje = 'Tu nivel de comprension de lectura es excelente.';
        }

        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS total FROM diagnostico WHERE id_estudiante = ?');
        $stmt->execute([$idEstudiante]);
        $tipo = ((int) $stmt->fetch()['total'] === 0) ? 'inicial' : 'final';

        $stmt = $this->pdo->prepare('INSERT INTO diagnostico (id_estudiante, tipo, nivel_resultado, puntaje) VALUES (?, ?, ?, ?)');
        $stmt->execute([$idEstudiante, $tipo, $nivel, $porcentaje]);
        $idDiagnostico = (int) $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare('UPDATE estudiante SET nivel_actual = ? WHERE id_estudiante = ?');
        $stmt->execute([$nivel, $idEstudiante]);

        actualizarRacha($this->pdo, $idEstudiante);

        responderJson([
            'ok' => true,
            'redirect' => 'index.php?page=resultado&id=' . $idDiagnostico,
        ]);
    }

    public function resultado(): void
    {
        requerirSesion('estudiante');
        $idEstudiante = (int) $_SESSION['id_usuario'];
        $id = (int) ($_GET['id'] ?? 0);

        $stmt = $this->pdo->prepare('SELECT * FROM diagnostico WHERE id_diagnostico = ? AND id_estudiante = ?');
        $stmt->execute([$id, $idEstudiante]);
        $diagnostico = $stmt->fetch();

        if (!$diagnostico) {
            $stmt = $this->pdo->prepare('SELECT * FROM diagnostico WHERE id_estudiante = ? ORDER BY fecha DESC LIMIT 1');
            $stmt->execute([$idEstudiante]);
            $diagnostico = $stmt->fetch();
        }

        if (!$diagnostico) {
            redirigir('index.php?page=diagnostico');
        }

        $nivel = (int) $diagnostico['nivel_resultado'];
        $porcentaje = (float) $diagnostico['puntaje'];
        $mensajes = [
            1 => 'Tu nivel de comprension de lectura es inicial.',
            2 => 'Tu nivel de comprension de lectura es basico.',
            3 => 'Tu nivel de comprension de lectura es bueno.',
            4 => 'Tu nivel de comprension de lectura es excelente.',
        ];
        $mensaje = $mensajes[$nivel] ?? $mensajes[1];

        require BASE_PATH . '/views/estudiante/resultado.php';
    }
}
