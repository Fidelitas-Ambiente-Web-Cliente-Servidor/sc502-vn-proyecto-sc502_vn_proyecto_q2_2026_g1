<?php

require_once __DIR__ . '/config/config.php';

$pagina = $_GET['page'] ?? 'index';

switch ($pagina) {
    case 'index':
        require BASE_PATH . '/views/auth/index.php';
        break;

    case 'login':
        (new AuthController())->mostrarLogin();
        break;

    case 'register':
        (new AuthController())->mostrarRegistro();
        break;

    case 'account-created':
        (new AuthController())->mostrarCuentaCreada();
        break;

    case 'forgot-password':
        (new AuthController())->mostrarOlvidoContrasena();
        break;

    case 'email-sent':
        (new AuthController())->mostrarCorreoEnviado();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'tutor-inicio':
        requerirSesion('tutor');
        require BASE_PATH . '/views/auth/tutor-inicio.php';
        break;

    case 'perfil':
        (new PerfilController())->index();
        break;

    case 'diagnostico':
        (new DiagnosticoController())->index();
        break;

    case 'resultado':
        (new DiagnosticoController())->resultado();
        break;

    case 'foro':
        (new ForoController())->index();
        break;

    case 'ranking':
        (new RankingController())->index();
        break;

    case 'profesor-clases':
        (new ProfesorController())->clases();
        break;

    case 'profesor-estudiantes':
        (new ProfesorController())->estudiantes();
        break;

    case 'profesor-ejercicios':
        (new ProfesorController())->ejercicios();
        break;

    case 'profesor-foro':
        (new ProfesorController())->foro();
        break;

    case 'profesor-reportes':
        (new ProfesorController())->reportes();
        break;

    default:
        http_response_code(404);
        echo '404 - Página no encontrada';
        break;
}
