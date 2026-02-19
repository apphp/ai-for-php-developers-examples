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
    <h1 class="h2"><?= __t('knn_local_solutions.index.case2'); ?></h1>
</div>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-4/k-nearest-neighbors-algorithm-and-local-solutions/case-2/apartment-price-estimation'); ?>

<div>
    <p>
        <?= __t('knn_local_solutions.case2.intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
