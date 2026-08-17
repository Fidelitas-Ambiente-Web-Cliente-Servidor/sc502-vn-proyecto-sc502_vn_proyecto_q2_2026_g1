<?php

class PerfilController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function index(): void
    {
        requerirSesion('estudiante');
        $idEstudiante = (int) $_SESSION['id_usuario'];

        $stmt = $this->pdo->prepare(
            'SELECT u.nombre_completo, e.nivel_actual
             FROM usuario u
             INNER JOIN estudiante e ON e.id_estudiante = u.id_usuario
             WHERE u.id_usuario = ?'
        );
        $stmt->execute([$idEstudiante]);
        $estudiante = $stmt->fetch();

        $stmt = $this->pdo->prepare('SELECT racha_actual, racha_maxima FROM racha WHERE id_estudiante = ?');
        $stmt->execute([$idEstudiante]);
        $racha = $stmt->fetch() ?: ['racha_actual' => 0, 'racha_maxima' => 0];

        $stmt = $this->pdo->prepare(
            'SELECT i.nombre, i.icono_url
             FROM estudiante_insignia ei
             INNER JOIN insignia i ON i.id_insignia = ei.id_insignia
             WHERE ei.id_estudiante = ?'
        );
        $stmt->execute([$idEstudiante]);
        $insignias = $stmt->fetchAll();

        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS total FROM progreso_actividad WHERE id_estudiante = ? AND completado = 1');
        $stmt->execute([$idEstudiante]);
        $finalizadas = (int) $stmt->fetch()['total'];

        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS total FROM progreso_actividad WHERE id_estudiante = ? AND completado = 0 AND intentos > 0');
        $stmt->execute([$idEstudiante]);
        $enProceso = (int) $stmt->fetch()['total'];

        $stmt = $this->pdo->prepare('SELECT COUNT(*) AS total FROM progreso_actividad WHERE id_estudiante = ? AND intentos = 0');
        $stmt->execute([$idEstudiante]);
        $guardadas = (int) $stmt->fetch()['total'];

        $puntos = calcularPuntosEstudiante($this->pdo, $idEstudiante);
        $estrellas = min(5, max(1, (int) ceil($estudiante['nivel_actual'] / 2)));

        $nivelesTexto = [1 => 'Inicial', 2 => 'Aprendiz', 3 => 'Explorador', 4 => 'Avanzado', 5 => 'Experto'];
        $nombreNivel = $nivelesTexto[(int) $estudiante['nivel_actual']] ?? 'Explorador';

        $progresoLectura = [
            ['estado' => 'En proceso', 'cantidad' => $enProceso, 'color' => '#4a90d9'],
            ['estado' => 'Guardados', 'cantidad' => $guardadas, 'color' => '#f5c518'],
            ['estado' => 'Finalizadas', 'cantidad' => $finalizadas, 'color' => '#2f4f4f'],
        ];

        require BASE_PATH . '/views/estudiante/perfil.php';
    }
}
