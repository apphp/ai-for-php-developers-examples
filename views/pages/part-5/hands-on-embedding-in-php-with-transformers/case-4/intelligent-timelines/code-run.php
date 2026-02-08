<?php

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include((APP_MODE === 'local' ? 'code-usage.php' : 'code-usage-prod.php'));

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('hands_on_embedding_in_php_with_transformers.case4.title'); ?></h1>
</div>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-5/hands-on-embedding-in-php-with-transformers/case-4/intelligent-timelines'); ?>

<div>
    <p>
        <?= __t('hands_on_embedding_in_php_with_transformers.case4.intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<br><br>
