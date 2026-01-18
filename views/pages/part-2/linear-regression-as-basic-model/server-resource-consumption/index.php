<?php

?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('linear_regression.heading'); ?></h1>
</div>

<?= create_run_code_button(__t('linear_regression.case3_title'), 'part-2/linear-regression-as-basic-model/case-3/server-resource-consumption/code-run'); ?>

<div>
    <p>
        <?= __t('linear_regression.case3.intro1'); ?>
    </p>

    <p>
        <?= __t('linear_regression.case3.intro2'); ?>
    </p>

    <ul>
        <li><?= __t('linear_regression.case3.feature_x1'); ?></li>
        <li><?= __t('linear_regression.case3.feature_x2'); ?></li>
        <li><?= __t('linear_regression.case3.feature_x3'); ?></li>
        <li><?= __t('linear_regression.case3.feature_x4'); ?></li>
        <li><?= __t('linear_regression.case3.feature_x5'); ?></li>
    </ul>

    <p>
        <?= __t('linear_regression.case3.formula'); ?>
    </p>
</div>

<div>
    <?= create_example_of_use_links(__DIR__ . '/code.php', opened: true, copyButtonId: 1, expandButtonId: 1); ?>
</div>
<br><br>

