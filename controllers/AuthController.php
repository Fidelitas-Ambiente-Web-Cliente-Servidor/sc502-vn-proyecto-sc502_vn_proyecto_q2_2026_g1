<?php

class AuthController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function mostrarLogin(): void
    {
        if (estaAutenticado()) {
            $this->redirigirSegunTipo();
        }
        require BASE_PATH . '/views/auth/login.php';
    }

    public function mostrarRegistro(): void
    {
        if (estaAutenticado()) {
            $this->redirigirSegunTipo();
        }
        require BASE_PATH . '/views/auth/register.php';
    }

    public function mostrarCuentaCreada(): void
    {
        require BASE_PATH . '/views/auth/account-created.php';
    }

    public function mostrarOlvidoContrasena(): void
    {
        require BASE_PATH . '/views/auth/forgot-password.php';
    }

    public function mostrarCorreoEnviado(): void
    {
        require BASE_PATH . '/views/auth/email-sent.php';
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            responderJson(['ok' => false, 'mensaje' => 'Completa correo y contraseña.'], 422);
        }

        $stmt = $this->pdo->prepare('SELECT * FROM usuario WHERE correo = ? AND activo = 1');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if (!$usuario || !password_verify($password, $usuario['contrasena_hash'])) {
            responderJson(['ok' => false, 'mensaje' => 'Correo o contraseña incorrectos.'], 401);
        }

        $_SESSION['id_usuario'] = (int) $usuario['id_usuario'];
        $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

        $destino = destinoSegunTipo();

        responderJson(['ok' => true, 'mensaje' => '¡Bienvenido de nuevo!', 'redirect' => $destino]);
    }

    public function registrar(): void
    {
        $nombre = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm'] ?? '';
        $tipo = $_POST['userType'] ?? '';
        $edad = isset($_POST['edad']) ? (int) $_POST['edad'] : null;
        $especialidad = trim($_POST['especialidad'] ?? '');

        if ($nombre === '' || $email === '' || strlen($password) < 8 || $password !== $confirm) {
            responderJson(['ok' => false, 'mensaje' => 'Revisa los datos ingresados.'], 422);
        }

        if (!in_array($tipo, ['estudiante', 'docente', 'tutor'], true)) {
            responderJson(['ok' => false, 'mensaje' => 'Selecciona un tipo de usuario válido.'], 422);
        }

        if ($tipo === 'estudiante' && (!$edad || $edad < 1 || $edad > 120)) {
            responderJson(['ok' => false, 'mensaje' => 'Ingresa una edad válida.'], 422);
        }

        $stmt = $this->pdo->prepare('SELECT id_usuario FROM usuario WHERE correo = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            responderJson(['ok' => false, 'mensaje' => 'Ese correo ya está registrado.'], 409);
        }

        $this->pdo->beginTransaction();
        try {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare('INSERT INTO usuario (nombre_completo, correo, contrasena_hash, tipo_usuario) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nombre, $email, $hash, $tipo]);
            $idUsuario = (int) $this->pdo->lastInsertId();

            if ($tipo === 'estudiante') {
                $stmt = $this->pdo->prepare('INSERT INTO estudiante (id_estudiante, edad, nivel_actual) VALUES (?, ?, 1)');
                $stmt->execute([$idUsuario, $edad]);
                $stmt = $this->pdo->prepare('INSERT INTO racha (id_estudiante, racha_actual, racha_maxima) VALUES (?, 0, 0)');
                $stmt->execute([$idUsuario]);
            } elseif ($tipo === 'docente') {
                $stmt = $this->pdo->prepare('INSERT INTO docente (id_docente, especialidad) VALUES (?, ?)');
                $stmt->execute([$idUsuario, $especialidad !== '' ? $especialidad : null]);
            }

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            responderJson(['ok' => false, 'mensaje' => 'No se pudo completar el registro.'], 500);
        }

        responderJson(['ok' => true, 'mensaje' => 'Cuenta creada con éxito.', 'redirect' => 'index.php?page=account-created']);
    }

    public function olvidoContrasena(): void
    {
        $email = trim($_POST['email'] ?? '');

        if ($email === '') {
            responderJson(['ok' => false, 'mensaje' => 'Ingresa tu correo electrónico.'], 422);
        }

        $stmt = $this->pdo->prepare('SELECT id_usuario FROM usuario WHERE correo = ?');
        $stmt->execute([$email]);

        if (!$stmt->fetch()) {
            responderJson(['ok' => false, 'mensaje' => 'No encontramos una cuenta con ese correo.'], 404);
        }

        $_SESSION['correo_recuperacion'] = $email;

        responderJson(['ok' => true, 'mensaje' => 'Enlace de recuperación enviado.', 'redirect' => 'index.php?page=email-sent']);
    }

    public function reenviarCorreo(): void
    {
        if (empty($_SESSION['correo_recuperacion'])) {
            responderJson(['ok' => false, 'mensaje' => 'No hay una solicitud de recuperación activa.'], 400);
        }
        responderJson(['ok' => true, 'mensaje' => 'Correo de recuperación reenviado.']);
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        redirigir('index.php?page=login');
    }

    private function redirigirSegunTipo(): void
    {
        redirigir(destinoSegunTipo());
    }
}
