<?php
$tituloPagina = 'Iniciar sesión — EduLecto';
$hojasEstilo = ['styles.css'];
require BASE_PATH . '/views/layout/header.php';
?>
  <div class="auth-screen">
    <aside class="auth-panel">
      <div class="auth-panel__owl">
        <img src="img/buho.png" alt="Búho mascota de EduLecto leyendo un libro" />
      </div>
      <p class="auth-panel__tagline">Aprende leyendo, jugando y ganando recompensas.</p>
    </aside>

    <section class="auth-form-wrap">
      <div class="auth-form-inner">
        <h1>Bienvenidos a EduLecto</h1>
        <p class="subtitle">Ingresa a tu cuenta para continuar</p>

        <form id="login-form" novalidate>
          <div class="field" id="field-email">
            <label for="email">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 6l10 7 10-7"/></svg>
              Correo electrónico
            </label>
            <div class="input-wrap">
              <input type="email" id="email" name="email" placeholder="tu@email.com" autocomplete="email" required />
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <div class="field" id="field-password">
            <label for="password">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              Contraseña
            </label>
            <div class="input-wrap">
              <input type="password" id="password" name="password" placeholder="Tu contraseña" autocomplete="current-password" required />
              <button type="button" class="toggle-visibility" aria-label="Mostrar contraseña">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <button type="submit" class="btn">Iniciar sesión</button>
        </form>

        <div class="auth-links">
          <p><a href="index.php?page=forgot-password">¿Olvidaste tu contraseña?</a></p>
          <p>
            ¿No tenés cuenta?<br />
            <a class="register-link" href="index.php?page=register">Registrate</a>
          </p>
        </div>
      </div>
    </section>
  </div>
<?php
$scripts = ['script.js'];
require BASE_PATH . '/views/layout/footer.php';
