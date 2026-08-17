<?php

require_once __DIR__ . '/config/config.php';

$accion = $_GET['action'] ?? '';

switch ($accion) {
    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->registrar();
        break;

    case 'forgotPassword':
        (new AuthController())->olvidoContrasena();
        break;

    case 'resendEmail':
        (new AuthController())->reenviarCorreo();
        break;

    case 'diagnosticoFinalizar':
        (new DiagnosticoController())->finalizar();
        break;

    case 'foroResponder':
        (new ForoController())->responder();
        break;

    case 'profesorEjercicioCrear':
        (new ProfesorController())->crearEjercicio();
        break;

    case 'profesorEjercicioActualizar':
        (new ProfesorController())->actualizarEjercicio();
        break;

    case 'profesorEjercicioEliminar':
        (new ProfesorController())->eliminarEjercicio();
        break;

    case 'profesorForoGuardar':
        (new ProfesorController())->guardarPreguntaForo();
        break;

    case 'profesorClaseCrear':
        (new ProfesorController())->crearClase();
        break;

    case 'profesorClaseObtener':
        (new ProfesorController())->obtenerClase();
        break;

    case 'profesorClaseActualizar':
        (new ProfesorController())->actualizarClase();
        break;

    case 'profesorClaseEliminar':
        (new ProfesorController())->eliminarClase();
        break;

    default:
        responderJson(['ok' => false, 'mensaje' => 'Acción no reconocida.'], 404);
        break;
}
