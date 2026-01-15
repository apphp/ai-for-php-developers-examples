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
    <h1 class="h2"><?= __t('errors_loss.heading')?></h1>
</div>

<?= create_show_code_button(__t('errors_loss.case2_title'), 'part-2/errors-and-loss-functions/case-2/model-selection-using-a-loss-function'); ?>

<div>
    <p>
        <?= __t('errors_loss.case2.block_intro'); ?>
    </p>
    <ul>
        <li><?= __t('errors_loss.case2.model_a'); ?></li>
        <li><?= __t('errors_loss.case2.model_b'); ?></li>
    </ul>
    <p><?= __t('errors_loss.case2.models_trained_text'); ?></p>
</div>


<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<p>
    <?= __t('errors_loss.case2.result_paragraph1'); ?>
    <?= __t('errors_loss.case2.result_paragraph2'); ?>
    <br>
    <?= __t('errors_loss.case2.result_paragraph3'); ?>
</p>
