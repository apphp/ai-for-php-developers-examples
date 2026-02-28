<?php
    /** @var string $query */
    /** @var array $results */
    $query = $query ?? '';
    $results = $results ?? [];
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h3 mb-0"><?= __t('search.title') ?></h1>
</div>

<form action="<?= create_href('search') ?>" method="get" class="mb-4">
    <div class="input-group">
        <input type="text" name="s" maxlength="100" class="form-control" placeholder="<?= __t('search.placeholder') ?>" aria-label="<?= __t('search.aria_label') ?>" value="<?= htmlspecialchars((string)$query, ENT_QUOTES, 'UTF-8') ?>">
        <button class="btn btn-sm btn-outline-primary" type="submit"><i class="fa-solid fa-magnifying-glass me-1"></i> <?= __t('search.button') ?></button>
    </div>
</form>

<?php if ($query !== ''): ?>
    <div class="mb-3">
        <strong><?= count($results) ?></strong> <?= __t('search.results_for') ?>
        <strong>"<?= htmlspecialchars((string)$query, ENT_QUOTES, 'UTF-8') ?>"</strong>
    </div>

    <?php if (!$results): ?>
        <div class="alert alert-secondary" role="alert">
            <?= __t('search.nothing_found') ?>
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($results as $item): ?>
                <a class="list-group-item list-group-item-action" href="<?= htmlspecialchars(create_href(ltrim((string)($item['url'] ?? ''), '/')), ENT_QUOTES, 'UTF-8') ?>">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?= htmlspecialchars((string)($item['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h5>
                    </div>
                    <p class="mb-1 text-muted">
                        <?= htmlspecialchars((string)($item['snippet'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <small class="text-muted text-black-50"><?= htmlspecialchars((string)($item['url'] ?? ''), ENT_QUOTES, 'UTF-8') ?></small>
                </a>
                <div class="mb-1"></div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<br><br>
<br><br>
