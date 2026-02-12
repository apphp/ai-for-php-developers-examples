<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

$apiKey = config('OPENAI_API_KEY');

if ($apiKey) {
    try {
        include((APP_MODE === 'local' ? 'llphant-code-usage.php' : 'llphant-code-usage-prod.php'));
    } catch (\Throwable $e) {
        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
    }
}

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

<?= create_show_code_button(__t('ml_ecosystem.sample_llphant_title'), 'ml-ecosystem-in-php', buttonText: __t('common.back')); ?>

<div>
    <p>
        <?= __t('ml_ecosystem.llphant_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/llphant-code-usage.php'); ?>

<?php
    if ($apiKey) {
        echo create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result);
    } else {
        echo '<div class="alert alert-warning" role="alert">OPENAI_API_KEY is not set. Add it to your <code>.env</code> file to run this example.</div>';
    }
?>
