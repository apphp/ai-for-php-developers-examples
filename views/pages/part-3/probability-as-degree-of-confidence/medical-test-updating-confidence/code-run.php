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

<?= create_show_code_button(__t('probability_confidence.case2_title'), 'part-3/probability-as-degree-of-confidence/case-2/medical-test-updating-confidence'); ?>

<div>
    <p>
        <?= __t('probability_confidence.intro'); ?>
    </p>
</div>

<div>
    <b><?= __t('probability_confidence.case2.scenario_title'); ?></b>
    <p>
        <?= __t('probability_confidence.case2.scenario_intro'); ?>
    </p>
    <ul>
        <li><?= __t('probability_confidence.case2.scenario_item1'); ?></li>
        <li><?= __t('probability_confidence.case2.scenario_item2'); ?></li>
        <li><?= __t('probability_confidence.case2.scenario_item3'); ?></li>
    </ul>
    <p>
        <?= __t('probability_confidence.case2.scenario_question'); ?>
    </p>
    <p>
        <?= __t('probability_confidence.case2.scenario_note'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
