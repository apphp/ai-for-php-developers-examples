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

<?= create_show_code_button(__t('logistic_regression.case2_title'), 'part-3/logistic-regression/case-2/newsletter-subscription'); ?>

<div>
    <p>
        <?= __t('logistic_regression.case2.intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(__DIR__ . '/code-usage.php'); ?>

<hr>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
<br><br>
