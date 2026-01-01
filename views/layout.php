<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title><?= htmlspecialchars($title ?? 'AI for PHP Developers', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" type="image/webp" href="/favicon.webp">
    <link href="/assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <header class="mb-4">
        <h1 class="h3 mb-1">AI for PHP Developers</h1>
    </header>

    <nav aria-label="Breadcrumbs" class="mb-3">
        <ol class="breadcrumb">
            <?php if (!empty($breadcrumbs)): ?>
                <?php foreach ($breadcrumbs as $crumb): ?>
                    <li class="breadcrumb-item<?= empty($crumb['url']) ? ' active' : '' ?>">
                        <?php if (!empty($crumb['url'])): ?>
                            <a href="<?= htmlspecialchars($crumb['url'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8') ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ol>
    </nav>

    <main>
        <?php
            if (!empty($contentTemplate)):
                // Content templates live in the same directory as this layout
                include __DIR__ . '/pages/' . $contentTemplate;
            endif;
        ?>
    </main>
</div>

</body>
</html>
