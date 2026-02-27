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
    <h1 class="h2"><?= __t('vectors_feature_spaces.vector_dimension.heading') ?></h1>
</div>

<?= create_show_code_button(__t('vectors_feature_spaces.vector_dimension.run_title'), '/part-1/vectors-dimensions-and-feature-spaces/vector-dimension'); ?>

<div>
    <p>
        <?= __t('vectors_feature_spaces.vector_dimension.run_intro') ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

<p>
    <?= __t('vectors_feature_spaces.vector_dimension.outro') ?>
</p>
<br><br>
