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
    <h1 class="h2"><?= __t('nav.part3_probability_confidence'); ?></h1>
</div>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-3/probability-as-degree-of-confidence/implementation'); ?>

<div>
    <p>
        <?= __t('probability_confidence.logits_paragraph'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<p>
    <?//= __t('errors_loss.case1.explanation');?>
    Теперь мы получили корректное распределение вероятностей:
    каждое значение находится в диапазоне от 0 до 1;
    сумма всех значений равна 1;
    числа можно интерпретировать как степень уверенности модели.
</p>

