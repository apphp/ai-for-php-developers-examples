<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

ob_start();

include __DIR__ . '/rubix-code-usage.php';

$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Почему наивный Байес работает</h1>
</div>

<h4>Кейс 1. Категориальные признаки и частоты</h4>
<br>

<?= create_show_code_button(__t('linear_regression.case1.rubix_impl_title'), 'part-3/why-naive-bayes-works/case-1/categorical-features-and-frequencies'); ?>

<div>
    <p>
        Здесь тот же кейс реализован через RubixML: мы обучаем наивный Байес на тех же данных и
        смотрим, какой класс модель назначит новому объекту.
    </p>
</div>

<?= create_example_of_use_block(__DIR__ . '/rubix-code-usage.php'); ?>

<hr>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
<br><br>

