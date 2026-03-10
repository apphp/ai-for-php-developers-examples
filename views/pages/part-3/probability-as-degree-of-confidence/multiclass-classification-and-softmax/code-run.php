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
    <h1 class="h2"><?= __t('nav.part3_probability_confidence'); ?></h1>
</div>

<?= create_show_code_button(__t('probability_confidence.case3_title'), 'part-3/probability-as-degree-of-confidence/case-3/multiclass-classification-and-softmax'); ?>

<div>
    <p>
        <?= __t('probability_confidence.intro'); ?>
    </p>
</div>

<div>
    <b><?= __t('probability_confidence.case3.scenario_title'); ?></b>
    <p>
        <?= __t('probability_confidence.case3.scenario_intro'); ?>
    </p>
    <p>
        <?= __t('probability_confidence.case3.scenario_note'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
<br><br>
