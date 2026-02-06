<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

ob_start();
//////////////////////////////

include((APP_MODE === 'local' ? 'transformers-code-usage.php' : 'transformers-code-usage-prod.php'));

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('ml_ecosystem.title'); ?></h1>
</div>

<h4><?= __t('ml_ecosystem.examples_heading'); ?></h4>

<p>
    <?= __t('ml_ecosystem.examples_intro'); ?>
</p>
<br>

<?= create_show_code_button(__t('ml_ecosystem.sample_transformers_title'), 'ml-ecosystem-in-php', buttonText: __t('common.back')); ?>

<div>
    <p>
        <?= __t('ml_ecosystem.transformers_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/transformers-code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
