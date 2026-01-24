<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

ob_start();

include __DIR__ . '/code-usage.php';

$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('nav.part3_logistic_regression'); ?></h1>
</div>

<h4><?= __t('logistic_regression.case1_title') ?></h4>
<br>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-3/logistic-regression/case-1/client-churn'); ?>

<div>
    <p>
        <?= __t('logistic_regression.case1.php_intro'); ?>
        <?= __t('logistic_regression.case1.php_intro2'); ?>
    </p>
</div>

<?= create_example_of_use_block(__DIR__ . '/code-usage.php'); ?>

<hr>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
<br><br>
