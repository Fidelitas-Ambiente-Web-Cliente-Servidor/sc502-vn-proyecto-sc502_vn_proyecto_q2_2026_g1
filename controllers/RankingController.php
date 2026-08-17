<?php

class RankingController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function index(): void
    {
        requerirSesion('estudiante');
        $idEstudianteActual = (int) $_SESSION['id_usuario'];

        $stmt = $this->pdo->query(
            'SELECT u.id_usuario, u.nombre_completo
             FROM usuario u
             INNER JOIN estudiante e ON e.id_estudiante = u.id_usuario
             WHERE u.activo = 1'
        );
        $estudiantes = $stmt->fetchAll();

        $jugadores = [];
        foreach ($estudiantes as $estudiante) {
            $jugadores[] = [
                'id' => (int) $estudiante['id_usuario'],
                'nombre' => $estudiante['nombre_completo'],
                'puntos' => calcularPuntosEstudiante($this->pdo, (int) $estudiante['id_usuario']),
            ];
        }

        usort($jugadores, fn($a, $b) => $b['puntos'] <=> $a['puntos']);

        require BASE_PATH . '/views/estudiante/ranking.php';
    }
}
