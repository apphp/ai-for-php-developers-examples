<?php

$currentLang ??= 'en';
$documents = $currentLang === 'ru'
    ? [
        'кот ест рыбу',
        'кот любит рыбу',
        'собака ест мясо из консервов',
    ]
    : [
        'The cat eats fish',
        'The cat loves fish',
        'The dog eats canned meat',
    ];


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
    <h1 class="h2"><?= __t('bag_of_words_and_tf_idf.simple_tfidf_example'); ?></h1>
</div>

<?= create_show_code_button(__t('bag_of_words_and_tf_idf.simple_tfidf_example'), 'part-5/bag-of-words-and-tf-idf/simple-tf-idf-example'); ?>

<div>
    <p>
        <?= __t('bag_of_words_and_tf_idf.simple_tfidf_example_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<div class="row">
    <div class="col-12 col-md-4">
        <?= create_dataset_and_test_data_links($documents, fullWidth: true, datasetOpened: true, datasetTitle: __t('common.documents')); ?>
    </div>
    <div class="col-12 col-md-8">
        <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
    </div>
</div>
<br><br>
