<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($tituloPagina ?? 'EduLecto') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <?php if (($fuente ?? 'nunito') === 'fredoka'): ?>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&display=swap" rel="stylesheet" />
    <?php else: ?>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <?php endif; ?>
    <?php foreach (($hojasEstilo ?? ['styles.css']) as $hoja): ?>
    <link rel="stylesheet" href="css/<?= htmlspecialchars($hoja) ?>" />
    <?php endforeach; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
