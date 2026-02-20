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
    <h1 class="h2"><?= __t('decision_trees_space_partitioning.index.case2'); ?></h1>
</div>

<?= create_show_code_button(__t('linear_regression.case1.rubix_impl_title'), 'part-4/decision-trees-and-space-partitioning/case-2/classification-with-rubixml'); ?>

<div>
    <p>
        <?= __t('decision_trees_space_partitioning.case2.rubix_run_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(__DIR__ . '/code-usage.php'); ?>

<hr>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
<div class="mt-3">
    <p>
        <?= __t('decision_trees_space_partitioning.case2.rubix_result_explanation'); ?>
    </p>
</div>

<br><br>
