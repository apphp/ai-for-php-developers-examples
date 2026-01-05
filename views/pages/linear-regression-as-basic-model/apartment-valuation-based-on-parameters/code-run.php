<?php
    $memoryStart = memory_get_usage();
    $microtimeStart = microtime(true);
    ob_start();
    //////////////////////////////

    include('code-usage.php');

    //////////////////////////////
    $result = ob_get_clean();
    $microtimeEnd = microtime(true);
    $memoryEnd = memory_get_usage();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('linear_regression.heading'); ?></h1>
</div>

<h4><?= __t('linear_regression.case1_title') ?></h4>
<br>

<?= create_show_code_button(__t('linear_regression.case1.php_impl_title'), 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters'); ?>

<div>
    <p>
        <?= __t('linear_regression.case1.php_impl_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<p>
    <?= __t('linear_regression.case1.php_result_intro'); ?>
</p>
<ul>
    <li><?= __t('linear_regression.case1.feature_area'); ?></li>
    <li><?= __t('linear_regression.case1.feature_rooms'); ?></li>
    <li><?= __t('linear_regression.case1.feature_bathrooms'); ?></li>
    <li><?= __t('linear_regression.case1.feature_floors'); ?></li>
    <li><?= __t('linear_regression.case1.feature_bias'); ?></li>
</ul>
