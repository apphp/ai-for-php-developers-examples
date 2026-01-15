<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('linear_regression.heading'); ?></h1>
</div>

<h4><?= __t('linear_regression.case1_title') ?></h4>
<br>

<?= create_run_code_button(__t('common.implementation_in_pure_php'), 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters/code-run'); ?>

<div>
    <p>
        <?= __t('linear_regression.case1.php_impl_intro'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: false, copyButtonId: 1, expandButtonId: 1); ?>
</div>

<hr>

<?= create_run_code_button(__t('linear_regression.case1.rubix_impl_title'), 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters/rubix-code-run'); ?>

<div>
    <p>
        <?= __t('linear_regression.case1.rubix_impl_intro'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/rubix-code.php', opened: false, copyButtonId: 2, expandButtonId: 2); ?>
</div>
<br><br>
