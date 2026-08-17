<?php
$tituloPagina = 'Crear cuenta — EduLecto';
$hojasEstilo = ['styles.css'];
require BASE_PATH . '/views/layout/header.php';
?>
  <div class="auth-screen">
    <aside class="auth-panel">
      <div class="auth-panel__owl">
        <img src="img/buho.png" alt="Búho mascota de EduLecto leyendo un libro" />
      </div>
      <p class="auth-panel__tagline">Crea una cuenta.</p>
    </aside>

    <section class="auth-form-wrap">
      <div class="auth-form-inner">
        <h1>Crear cuenta en EduLecto</h1>
        <p class="subtitle">Completa el formulario para comenzar tu experiencia</p>

        <form id="register-form" novalidate>
          <div class="field" id="field-name">
            <label for="name">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
              Nombre completo *
            </label>
            <div class="input-wrap">
              <input type="text" id="name" name="name" placeholder="Ingresa tu nombre completo" autocomplete="name" required />
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <div class="field" id="field-email">
            <label for="email">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 6l10 7 10-7"/></svg>
              Correo electrónico *
            </label>
            <div class="input-wrap">
              <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" autocomplete="email" required />
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <div class="field" id="field-password">
            <label for="password">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              Contraseña *
            </label>
            <div class="input-wrap">
              <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" autocomplete="new-password" required minlength="8" />
              <button type="button" class="toggle-visibility" aria-label="Mostrar contraseña">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <div class="field" id="field-confirm">
            <label for="confirm">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              Confirmar contraseña *
            </label>
            <div class="input-wrap">
              <input type="password" id="confirm" name="confirm" placeholder="Repite tu contraseña" autocomplete="new-password" required />
              <button type="button" class="toggle-visibility" aria-label="Mostrar contraseña">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <div class="field" id="field-type">
            <label for="userType">
              <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3"/><path d="M2 20c0-3.3 3.1-5 7-5s7 1.7 7 5"/><circle cx="18" cy="9" r="2.5"/><path d="M15.5 14.2c2.8.2 5.5 1.6 5.5 4.3"/></svg>
              Tipo de usuario *
            </label>
            <div class="input-wrap">
              <select id="userType" name="userType" required>
                <option value="" disabled selected>Selecciona tu tipo de usuario</option>
                <option value="estudiante">Estudiante</option>
                <option value="docente">Docente</option>
                <option value="tutor">Padre / Tutor</option>
              </select>
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <div class="field" id="field-edad" style="display:none;">
            <label for="edad">Edad *</label>
            <div class="input-wrap">
              <input type="number" id="edad" name="edad" min="1" max="120" placeholder="Edad del estudiante" />
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <div class="field" id="field-especialidad" style="display:none;">
            <label for="especialidad">Especialidad</label>
            <div class="input-wrap">
              <input type="text" id="especialidad" name="especialidad" placeholder="Ej: Comprensión lectora" />
            </div>
            <p class="field-error" role="alert"></p>
          </div>

          <button type="submit" class="btn">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
            Registrarse
          </button>
        </form>

        <div class="auth-links">
          <p>
            ¿Ya tenés una cuenta?<br />
            <a class="register-link" href="index.php?page=login">Iniciar sesión</a>
          </p>
        </div>
      </div>
    </section>
  </div>
<?php
$scripts = ['script.js'];
require BASE_PATH . '/views/layout/footer.php';
