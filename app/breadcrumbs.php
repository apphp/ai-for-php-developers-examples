<?php
// Expecting $breadcrumbs to be an array of ['label' => string, 'url' => string|null]
// Example:
// [
//   ['label' => 'Home', 'url' => '/'],
//   ['label' => 'Section', 'url' => '/section'],
//   ['label' => 'Current page', 'url' => null],
// ]

if (!empty($breadcrumbs) && is_array($breadcrumbs)):
    $lastIndex = array_key_last($breadcrumbs);
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php foreach ($breadcrumbs as $index => $crumb):
                $label = htmlspecialchars($crumb['label'] ?? '', ENT_QUOTES, 'UTF-8');
                $url = $crumb['url'] ?? null;
                $isLast = ($index === $lastIndex);

                // Build full URL if a relative URL is provided
                if (!empty($url) && str_starts_with($url, '/')) {
                    $href = APP_URL . ltrim($url, '/');
                } else {
                    $href = $url;
                }
                ?>

                <?php if ($isLast): ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= $label ?></li>
                <?php elseif (!empty($href)): ?>
                    <li class="breadcrumb-item"><a href="<?= $href ?>"><?= $label ?></a></li>
                <?php else: ?>
                    <li class="breadcrumb-item"><?= $label ?></li>
                <?php endif; ?>

            <?php endforeach; ?>
        </ol>
    </nav>

<?php endif; ?>
