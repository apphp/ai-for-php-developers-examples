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
    <h1 class="h2"><?= __t('gradient_descent.sample1_title'); ?></h1>
</div>

<?= create_show_code_button(__t('gradient_descent.sample1_title'), 'part-2/gradient-descent-on-fingers/sample-1/parameter-trajectory'); ?>

<div>
    <p>
        <?= __t('gradient_descent.sample1.run_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<br><br>
