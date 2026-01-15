<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('errors_loss.heading')?></h1>
</div>

<?= create_run_code_button(__t('errors_loss.case2_title'), 'part-2/errors-and-loss-functions/case-2/model-selection-using-a-loss-function/code-run'); ?>

<div>
    <p>
        <?= __t('errors_loss.case2.block_intro'); ?>
    </p>
    <ul>
        <li><?= __t('errors_loss.case2.model_a'); ?></li>
        <li><?= __t('errors_loss.case2.model_b'); ?></li>
    </ul>
    <p><?= __t('errors_loss.case2.models_trained_text'); ?></p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', title: 'Мы используем ту же функцию MSE, что и в предыдущем кейсе', opened: true); ?>
</div>
<br><br>
