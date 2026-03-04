<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('rubix-code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('errors_loss.heading')?></h1>
</div>

<h4><?= __t('errors_loss.case5_title') ?></h4>
<br>

<?= create_show_code_button(__t('common.implementation_in_rubixml'), 'part-2/errors-and-loss-functions/case-5/training-model-as-minimizing-error'); ?>

<p>
    <?= __t('errors_loss.case5.rubix_intro'); ?>
</p>

<div>
    <?= create_example_of_use_block(dirname(__FILE__) . '/rubix-code-usage.php'); ?>
</div>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
<br><br>
