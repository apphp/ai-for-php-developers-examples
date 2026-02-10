<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include 'code-usage.php';

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('linear_regression.heading'); ?></h1>
</div>

<?= create_show_code_button(__t('linear_regression.case4_title'), 'part-2/linear-regression-as-basic-model/case-4/customer-check-valuation'); ?>

<div>
    <p>
        <?= __t('linear_regression.case4.rubix_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<p>
    <?= __t('linear_regression.case4.explain_intro'); ?>
</p>
<ul>
    <li><?= __t('linear_regression.case4.explain_item1'); ?></li>
    <li><?= __t('linear_regression.case4.explain_item2'); ?></li>
    <li><?= __t('linear_regression.case4.explain_item3'); ?></li>
    <li><?= __t('linear_regression.case4.explain_item4'); ?></li>
</ul>
<p>
    <?= __t('linear_regression.case4.explain_outro'); ?>
</p>
