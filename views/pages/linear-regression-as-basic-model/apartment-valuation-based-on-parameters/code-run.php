<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);
ob_start();
//////////////////////////////

include('code-usage.php');

//////////////////////////////
$result = ob_get_clean();
$microtimeEnd = microtime(true);
$memoryEnd = memory_get_usage();

$predictedPrice = 78374;
function makeFeatureSamples(array $X, int $featureIndex): array {
    $samples = [];
    foreach ($X as $row) {
        $samples[] = [$row[$featureIndex]]; // drawLinearRegression expects [[x], [x], ...]
    }
    return $samples;
}

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('linear_regression.heading'); ?></h1>
</div>

<h4><?= __t('linear_regression.case1_title') ?></h4>
<br>

<?= create_show_code_button(__t('linear_regression.case1.php_impl_title'), 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters'); ?>

<div>
    <p>
        <?= __t('linear_regression.case1.php_impl_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-1 pe-4">
            <p><b>Chart:</b></p>
            <?php
                $charts = [
                    [
                        'featureIndex' => 0,
                        'xLabel'       => 'Area (sq.m)',
                        'yLabel'       => 'Price ($)',
                        'datasetLabel' => 'Price vs Area',
                        'regressionLabel' => 'Regression Line',
                        'chartId'      => 'areaPriceChart',
                        'minX'         => 40,
                        'minY'         => 10_000,
                        'showPrediction' => true,
                        'predictionX'    => 60,
                    ],
                    [
                        'featureIndex' => 1,
                        'xLabel'       => 'Floor',
                        'yLabel'       => 'Price ($)',
                        'datasetLabel' => 'Price vs Floor',
                        'regressionLabel' => 'Regression Line',
                        'chartId'      => 'floorPriceChart',
                        'minX'         => 1,
                        'minY'         => 15,
                        'showPrediction' => true,
                        'predictionX'    => 5,
                    ],
                    [
                        'featureIndex'   => 2,
                        'xLabel'         => 'Distance to City Center (km)',
                        'yLabel'         => 'Price ($)',
                        'datasetLabel'   => 'Price vs Distance',
                        'regressionLabel'=> 'Regression Line',
                        'chartId'        => 'distancePriceChart',
                        'minX'         => 0,
                        'minY'         => 0,
                        'showPrediction' => true,
                        'predictionX'    => 4,
                    ],
                    [
                        'featureIndex'   => 3,
                        'xLabel'         => 'Building Age (years)',
                        'yLabel'         => 'Price ($)',
                        'datasetLabel'   => 'Price vs Age',
                        'regressionLabel'=> 'Regression Line',
                        'chartId'        => 'agePriceChart',
                        'minX'         => 0,
                        'minY'         => 0,
                        'showPrediction' => true,
                        'predictionX'    => 12,
                    ],
                ];

            foreach ($charts as $cfg) {
                $predictionPoint = (!empty($cfg['showPrediction']) && isset($cfg['predictionX']))
                    ? [$cfg['predictionX'], round($predictedPrice)]
                    : [];

                echo Chart::drawLinearRegression(
                    samples: makeFeatureSamples($X, $cfg['featureIndex']),
                    labels: $y,
                    xLabel: $cfg['xLabel'],
                    yLabel: $cfg['yLabel'],
                    datasetLabel: $cfg['datasetLabel'],
                    regressionLabel: $cfg['regressionLabel'],
                    predictionPoint: $predictionPoint,
                    minX: $cfg['minX'] ?? 0,
                    minY: $cfg['minY'] ?? 0,
                    chartId: $cfg['chartId'],
                );
            }
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <?= create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result); ?>

            <p>
                <?= __t('linear_regression.case1.php_result_intro'); ?>
            </p>
            <ul>
                <li><?= __t('linear_regression.case1.feature_area'); ?></li>
                <li><?= __t('linear_regression.case1.feature_rooms'); ?></li>
                <li><?= __t('linear_regression.case1.feature_bathrooms'); ?></li>
                <li><?= __t('linear_regression.case1.feature_floors'); ?></li>
                <li><?= __t('linear_regression.case1.feature_bias'); ?></li>
            </ul>
        </div>
    </div>
</div>



