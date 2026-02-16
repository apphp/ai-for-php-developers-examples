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
    <h1 class="h2"><?= __t('why_naive_bayes_works.title'); ?></h1>
</div>

<h4><?= __t('why_naive_bayes_works.case2.title'); ?></h4>
<br>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-3/why-naive-bayes-works/case-2/spam-filter-on-words-bernoulli-naive-bayes'); ?>

<div>
    <p>
        <?= __t('why_naive_bayes_works.case2.php_run_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(__DIR__ . '/code-usage.php'); ?>

<hr>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<div class="mt-3">
    <p>
        <?= __t('why_naive_bayes_works.case2.php_result_explanation', ['spam' => round($scores['spam'], 3), 'ham' => round($scores['ham'], 3)]); ?>
    </p>
</div>

<br><br>
