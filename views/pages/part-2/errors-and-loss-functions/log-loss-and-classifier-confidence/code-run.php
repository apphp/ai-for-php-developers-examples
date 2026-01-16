<?php

use app\classes\Chart;

require_once __DIR__ . '/code.php';

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

// Handle parameters
// ----------------------------------
// Base set of probabilities and shared options for all five positions
$baseProbsA = [0.95, 0.10, 0.90, 0.20, 0.85];
$sharedOptions = ['' => range(0.99, 0.09, -0.01)];
$roundedArray = array_map(fn ($v) => round($v, 2), $sharedOptions['']);
$probsAValues = [];

for ($i = 0; $i < count($baseProbsA); $i++) {
    $index = $i + 1;

    // Create variables like $probsA1Options, $probsA2Options, ...
    ${"probsA{$index}Options"} = $sharedOptions;

    // Read value from GET and validate against the shared set
    $value = $_GET["probsA{$index}"] ?? '';
    verify_fields($value, $roundedArray, $baseProbsA[$i]);

    // Store back into variables like $probsA1, $probsA2, ...
    ${"probsA{$index}"} = $value;

    // Collect all validated values into a single 0-based array as well
    $probsAValues[$i] = $value;
}
// ----------------------------------

// Prepare per-sample log loss data for model A using the validated probsAValues
$yTrue = [1, 0, 1, 0, 1];
$perSampleLoss = [];
$eps = 1e-15;

foreach ($yTrue as $i => $y) {
    $p = isset($probsAValues[$i]) && $probsAValues[$i] !== ''
        ? (float) $probsAValues[$i]
        : $baseProbsA[$i];

    // logLossTerm сам делает clamp и вычисляет вклад
    $perSampleLoss[] = logLossTerm($y, $eps, $p);
}

ob_start();
//////////////////////////////

include('code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('errors_loss.heading')?></h1>
</div>

<?= create_show_code_button(__t('errors_loss.case3_title'), 'part-2/errors-and-loss-functions/case-3/log-loss-and-classifier-confidence'); ?>

<div>
    <p>
        <?= __t('errors_loss.case3.intro1'); ?>
    </p>

    <p>
        <?= __t('errors_loss.case3.intro2'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-6 pe-5">
            <div class="mt-4">
                <h5><?= __t('errors_loss.case3.per_sample_heading'); ?></h5>
                <?= Chart::drawBarsChars(
                    $perSampleLoss,
                    $probsAValues,
                    datasetLabel: __t('errors_loss.case3.per_sample_dataset_label'),
                    functionLabel: __t('errors_loss.case3.per_sample_dataset_label'),
                    xAxisLabel: __t('errors_loss.case3.sample_index_label'),
                ); ?>
            </div>
            <div class="mt-4">
                <h5><?= __t('errors_loss.case3.curve_heading'); ?></h5>
                <?= Chart::drawLogLossCurve(); ?>
            </div>

            <p class="mt-3">
                <?= __t('errors_loss.case3.explanation'); ?>
            </p>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <form class="mt-2" action="<?= APP_URL ?>part-2/errors-and-loss-functions/case-3/log-loss-and-classifier-confidence/code-run" type="GET">
                <label class="form-label">Probabilities for model A:</label>
                <br>
                <?= create_form_features($probsA1Options, [$probsA1], fieldName: 'probsA1', type: 'number', step: 0.01, precisionCompare: true, class: 'w-20 me-0', initId: 0); ?>
                <?= create_form_features($probsA2Options, [$probsA2], fieldName: 'probsA2', type: 'number', step: 0.01, precisionCompare: true, class: 'w-20 me-0', initId: 1); ?>
                <?= create_form_features($probsA3Options, [$probsA3], fieldName: 'probsA3', type: 'number', step: 0.01, precisionCompare: true, class: 'w-20 me-0', initId: 2); ?>
                <?= create_form_features($probsA4Options, [$probsA4], fieldName: 'probsA4', type: 'number', step: 0.01, precisionCompare: true, class: 'w-20 me-0', initId: 3); ?>
                <?= create_form_features($probsA5Options, [$probsA5], fieldName: 'probsA5', type: 'number', step: 0.01, precisionCompare: true, class: 'w-20 me-0', initId: 4); ?>

                <br>
                <div class="form-text">
                    <?= __t('common.example'); ?>: <code>0.95, 0.10, 0.90, 0.20, 0.85</code>
                </div>

                <br>
                <div class="form-check form-check-inline float-start p-0 m-0 me-1">
                    <button type="submit" class="btn btn-sm btn-outline-primary"><?= __t('common.regenerate'); ?></button>
                </div>
                <div class="clearfix"></div>
                <hr>
            </form>

            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>
        </div>
    </div>
</div>







