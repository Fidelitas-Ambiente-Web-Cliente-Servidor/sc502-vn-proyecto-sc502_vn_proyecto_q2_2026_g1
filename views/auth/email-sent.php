<?php
$tituloPagina = 'Correo enviado — EduLecto';
$hojasEstilo = ['styles.css'];
require BASE_PATH . '/views/layout/header.php';
?>
  <div class="auth-screen">
    <aside class="auth-panel">
      <div class="auth-panel__owl">
        <img src="img/buho.png" alt="Búho mascota de EduLecto leyendo un libro" />
      </div>
      <p class="auth-panel__tagline">El correo ha sido enviado</p>
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

        <h1>Correo de recuperación enviado</h1>
        <p class="lead">
          Hemos enviado un enlace a tu correo electrónico para restablecer tu contraseña.
          Revisa tu bandeja de entrada o la carpeta de spam.
        </p>

        <a class="btn back-link" href="index.php?page=login" style="margin-top:0;">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          Volver al inicio de sesión
        </a>

        <div class="info-box warning">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v5M12 16h.01"/></svg>
          <div><strong>Por tu seguridad,</strong> el enlace expirará en 24 horas.</div>
        </div>

        <div class="resend-block">
          ¿No recibiste el correo?
          <button type="button" id="resend-btn">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 4v6h6M23 20v-6h-6"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
            Reenviar correo de recuperación
          </button>
        </div>

        <div class="support-note">
          ¿Necesitas ayuda?<br />
          <a href="mailto:soporte@edulecto.com">Contacta con soporte</a>
        </div>
      </div>
    </section>
  </div>
<?php
$scripts = ['script.js'];
require BASE_PATH . '/views/layout/footer.php';
