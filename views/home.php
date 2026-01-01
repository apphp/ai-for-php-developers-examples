<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Home', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
<nav aria-label="Breadcrumbs">
    <ol>
        <?php if (!empty($breadcrumbs)): ?>
            <?php foreach ($breadcrumbs as $crumb): ?>
                <li>
                    <?php if (!empty($crumb['url'])): ?>
                        <a href="<?= htmlspecialchars($crumb['url'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    <?php else: ?>
                        <span><?= htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ol>
</nav>

<h1><?= htmlspecialchars($message ?? 'Hello, World!', ENT_QUOTES, 'UTF-8') ?></h1>
</body>
</html>
