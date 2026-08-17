<?php
$tituloPagina = 'EduLecto - Tutor';
$hojasEstilo = ['styles.css'];
require BASE_PATH . '/views/layout/header.php';
?>
  <main class="splash-screen">
    <div class="splash-card">
      <h1 class="logo">EduLecto</h1>
      <img class="owl" src="img/buho.png" alt="Búho mascota de EduLecto leyendo un libro" />
      <p>Hola <?= htmlspecialchars($_SESSION['nombre_completo']) ?>, tu panel de tutor estará disponible próximamente.</p>
      <a class="btn" href="index.php?page=logout">Salir</a>
    </div>
  </main>
<?php
$scripts = [];
require BASE_PATH . '/views/layout/footer.php';
