<?php
$tituloPagina = 'Cuenta creada — EduLecto';
$hojasEstilo = ['styles.css'];
require BASE_PATH . '/views/layout/header.php';
?>
  <div class="auth-screen">
    <aside class="auth-panel">
      <div class="auth-panel__owl">
        <img src="img/buho.png" alt="Búho mascota de EduLecto leyendo un libro" />
      </div>
      <p class="auth-panel__tagline">Cuenta creada.</p>
    </aside>

    <section class="auth-form-wrap">
      <div class="auth-form-inner status-panel">
        <div class="status-icon-stack">
          <div class="envelope">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 6l10 7 10-7"/></svg>
          </div>
          <div class="check">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
          </div>
        </div>

        <h1>Registrado correctamente</h1>
        <p class="lead">Su cuenta ha sido creada con éxito.</p>

        <a class="btn" href="index.php?page=login">Iniciar sesión</a>
      </div>
    </section>
  </div>
<?php
$scripts = ['script.js'];
require BASE_PATH . '/views/layout/footer.php';
