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
    <h1 class="h2">Почему наивный Байес работает</h1>
</div>

<h4>Кейс 1. Категориальные признаки и частоты</h4>
<br>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-3/why-naive-bayes-works/case-1/categorical-features-and-frequencies'); ?>

<div>
    <p>
        В этом примере мы руками реализуем наивный Байес для пары простых категориальных признаков
        и посмотрим, какие логарифмы вероятностей получаются для классов.
    </p>
</div>

<?= create_example_of_use_block(__DIR__ . '/code-usage.php'); ?>

<hr>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
<br><br>

