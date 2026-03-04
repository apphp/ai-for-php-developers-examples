<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('errors_loss.heading')?></h1>
</div>

<h4><?= __t('errors_loss.case5_title') ?></h4>
<br>

<?= create_run_code_button(__t('common.implementation_in_pure_php'), 'part-2/errors-and-loss-functions/case-5/training-model-as-minimizing-error/code-run'); ?>

<div>
    <p>
        <?= __t('errors_loss.case5.pure_php_intro1'); ?>
        <?= __t('errors_loss.case5.pure_php_intro2'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: false, copyButtonId: 1, expandButtonId: 1); ?>
</div>

<hr>

<?= create_run_code_button(__t('common.implementation_in_rubixml'), 'part-2/errors-and-loss-functions/case-5/training-model-as-minimizing-error/rubix-code-run'); ?>

<div>
    <p>
        <?= __t('errors_loss.case5.rubix_intro'); ?>
    </p>

    <?= create_example_of_use_links(__DIR__ . '/rubix-code.php', opened: false, copyButtonId: 2, expandButtonId: 2); ?>
</div>
<br><br>
