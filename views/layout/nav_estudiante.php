    <nav class="navbar">
        <a href="index.php?page=perfil">Inicio</a>
        <a href="index.php?page=perfil" class="<?= ($paginaActiva ?? '') === 'perfil' ? 'activo' : '' ?>">Perfil</a>
        <a href="index.php?page=foro" class="<?= ($paginaActiva ?? '') === 'foro' ? 'activo' : '' ?>">Foro</a>
        <a href="index.php?page=ranking" class="<?= ($paginaActiva ?? '') === 'ranking' ? 'activo' : '' ?>">Ranking</a>
        <a href="index.php?page=logout">Salir</a>
    </nav>
