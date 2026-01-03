<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('errors_loss.heading')?></h1>
</div>

<?= create_run_code_button(__t('errors_loss.case1_title'), 'part-2/errors-and-loss-functions/case-1/mse-and-cost-of-a-big-miss/code-run'); ?>

<div>
    <p>
        <?= __t('errors_loss.case1.intro1'); ?>
    </p>

    <p>
        <?= __t('errors_loss.case1.intro2'); ?>
    </p>

    <p>
        <?= __t('errors_loss.case1.mse_description'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true); ?>
</div>
