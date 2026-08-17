    <?php foreach (($scripts ?? []) as $script): ?>
    <script src="js/<?= htmlspecialchars($script) ?>?v=<?= @filemtime(BASE_PATH . '/js/' . $script) ?: time() ?>"></script>
    <?php endforeach; ?>
</body>
</html>
