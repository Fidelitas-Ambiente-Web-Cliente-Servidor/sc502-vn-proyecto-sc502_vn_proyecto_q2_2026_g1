    <nav class="navbar">
        <a href="index.php?page=profesor-reportes">Inicio</a>
        <a href="index.php?page=profesor-estudiantes" class="<?= ($paginaActiva ?? '') === 'estudiantes' ? 'activo' : '' ?>">Estudiantes</a>
        <a href="index.php?page=profesor-ejercicios" class="<?= ($paginaActiva ?? '') === 'ejercicios' ? 'activo' : '' ?>">Ejercicios</a>
        <a href="index.php?page=profesor-clases" class="<?= ($paginaActiva ?? '') === 'clases' ? 'activo' : '' ?>">Clases</a>
        <a href="index.php?page=profesor-foro" class="<?= ($paginaActiva ?? '') === 'foro' ? 'activo' : '' ?>">Foro</a>
        <a href="index.php?page=profesor-reportes" class="<?= ($paginaActiva ?? '') === 'reportes' ? 'activo' : '' ?>">Reportes</a>
        <a href="index.php?page=logout">Salir</a>
    </nav>
