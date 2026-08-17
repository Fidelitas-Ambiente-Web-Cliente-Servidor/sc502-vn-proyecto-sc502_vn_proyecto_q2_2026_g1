<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '');

require_once BASE_PATH . '/config/database.php';

spl_autoload_register(function ($class) {
    $path = BASE_PATH . '/controllers/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

function estaAutenticado(): bool
{
    return isset($_SESSION['id_usuario']);
}

function tipoUsuarioActual(): ?string
{
    return $_SESSION['tipo_usuario'] ?? null;
}

function destinoSegunTipo(): string
{
    $tipo = tipoUsuarioActual();
    if ($tipo === 'docente') {
        return 'index.php?page=profesor-reportes';
    }
    if ($tipo === 'tutor') {
        return 'index.php?page=tutor-inicio';
    }
    return 'index.php?page=perfil';
}

function requerirSesion(?string $tipoRequerido = null): void
{
    if (!estaAutenticado()) {
        header('Location: index.php?page=login');
        exit;
    }
    if ($tipoRequerido !== null && tipoUsuarioActual() !== $tipoRequerido) {
        header('Location: ' . destinoSegunTipo());
        exit;
    }
}

function redirigir(string $destino): void
{
    header('Location: ' . $destino);
    exit;
}

function responderJson(array $datos, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

function normalizarTexto(string $texto): string
{
    $texto = trim(mb_strtolower($texto));
    $texto = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
        ['a', 'e', 'i', 'o', 'u', 'n'],
        $texto
    );
    return $texto;
}

function actualizarRacha(PDO $pdo, int $idEstudiante): void
{
    $hoy = date('Y-m-d');
    $ayer = date('Y-m-d', strtotime('-1 day'));

    $stmt = $pdo->prepare('SELECT * FROM racha WHERE id_estudiante = ?');
    $stmt->execute([$idEstudiante]);
    $racha = $stmt->fetch();

    if (!$racha) {
        $stmt = $pdo->prepare('INSERT INTO racha (id_estudiante, racha_actual, racha_maxima, ultima_fecha_actividad) VALUES (?, 1, 1, ?)');
        $stmt->execute([$idEstudiante, $hoy]);
        return;
    }

    if ($racha['ultima_fecha_actividad'] === $hoy) {
        return;
    }

    if ($racha['ultima_fecha_actividad'] === $ayer) {
        $nuevaRacha = (int) $racha['racha_actual'] + 1;
    } else {
        $nuevaRacha = 1;
    }

    $nuevaMaxima = max((int) $racha['racha_maxima'], $nuevaRacha);

    $stmt = $pdo->prepare('UPDATE racha SET racha_actual = ?, racha_maxima = ?, ultima_fecha_actividad = ? WHERE id_estudiante = ?');
    $stmt->execute([$nuevaRacha, $nuevaMaxima, $hoy, $idEstudiante]);
}

function calcularPuntosEstudiante(PDO $pdo, int $idEstudiante): int
{
    $stmt = $pdo->prepare('SELECT COALESCE(SUM(puntaje), 0) AS total FROM progreso_actividad WHERE id_estudiante = ?');
    $stmt->execute([$idEstudiante]);
    $puntosActividades = (int) $stmt->fetch()['total'];

    $stmt = $pdo->prepare('SELECT COALESCE(SUM(puntaje), 0) AS total FROM diagnostico WHERE id_estudiante = ?');
    $stmt->execute([$idEstudiante]);
    $puntosDiagnostico = (int) round((float) $stmt->fetch()['total']);

    $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM intento_foro WHERE id_estudiante = ? AND correcta = 1');
    $stmt->execute([$idEstudiante]);
    $puntosForo = (int) $stmt->fetch()['total'] * 5;

    return $puntosActividades + $puntosDiagnostico + $puntosForo;
}
