<?php

use app\classes\Chart;

$memoryStart = memory_get_usage();
$microtimeStart = microtime(true);

// Handle parameters
$chartTypeOptions = [
    __t('linear_regression.case1.chart_price_vs_area') => 0,
    __t('linear_regression.case1.chart_price_vs_floor') => 1,
    __t('linear_regression.case1.chart_price_vs_distance') => 2,
    __t('linear_regression.case1.chart_price_vs_age') => 3,
];
$chartType = isset($_GET['chartTypes']) && is_string($_GET['chartTypes']) ? $_GET['chartTypes'] : '';
verify_fields($chartType, array_values($chartTypeOptions), reset($chartTypeOptions));
$selectedChartIndex = (int)$chartType;

$predictedPrice = 78374;
function makeFeatureSamples(array $X, int $featureIndex): array {
    $samples = [];
    foreach ($X as $row) {
        $samples[] = [$row[$featureIndex]]; // drawLinearRegression expects [[x], [x], ...]
    }
    return $samples;
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
    <h1 class="h2"><?= __t('linear_regression.heading'); ?></h1>
</div>

<h4><?= __t('linear_regression.case1_title') ?></h4>
<br>

<?= create_show_code_button(__t('common.implementation_in_pure_php'), 'part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters'); ?>

<div>
    <p>
        <?= __t('linear_regression.case1.php_impl_intro'); ?>
    </p>
</div>

<?= create_example_of_use_block(dirname(__FILE__) . '/code-usage.php'); ?>

<div class="container-fluid px-2">
    <div class="row justify-content-start p-0">
        <div class="col-md-12 col-lg-7 px-6 pe-5">
            <p><b><?= __t('common.charts'); ?>:</b></p>
            <?php
                $charts = [
                    [
                        'featureIndex' => 0,
                        'xLabel'       => __t('linear_regression.case1.chart_xlabel_area'),
                        'yLabel'       => __t('linear_regression.case1.chart_ylabel_price'),
                        'datasetLabel' => __t('linear_regression.case1.chart_price_vs_area'),
                        'regressionLabel' => __t('linear_regression.case1.chart_regression_label'),
                        'chartId'      => 'areaPriceChart',
                        'minX'         => 40,
                        'minY'         => 10_000,
                        'showPrediction' => true,
                        'predictionX'    => 60,
                    ],
                    [
                        'featureIndex' => 1,
                        'xLabel'       => __t('linear_regression.case1.chart_xlabel_floor'),
                        'yLabel'       => __t('linear_regression.case1.chart_ylabel_price'),
                        'datasetLabel' => __t('linear_regression.case1.chart_price_vs_floor'),
                        'regressionLabel' => __t('linear_regression.case1.chart_regression_label'),
                        'chartId'      => 'floorPriceChart',
                        'minX'         => 1,
                        'minY'         => 15,
                        'showPrediction' => true,
                        'predictionX'    => 5,
                    ],
                    [
                        'featureIndex'   => 2,
                        'xLabel'         => __t('linear_regression.case1.chart_xlabel_distance'),
                        'yLabel'         => __t('linear_regression.case1.chart_ylabel_price'),
                        'datasetLabel'   => __t('linear_regression.case1.chart_price_vs_distance'),
                        'regressionLabel'=> __t('linear_regression.case1.chart_regression_label'),
                        'chartId'        => 'distancePriceChart',
                        'minX'         => 0,
                        'minY'         => 0,
                        'showPrediction' => true,
                        'predictionX'    => 4,
                    ],
                    [
                        'featureIndex'   => 3,
                        'xLabel'         => __t('linear_regression.case1.chart_xlabel_age'),
                        'yLabel'         => __t('linear_regression.case1.chart_ylabel_price'),
                        'datasetLabel'   => __t('linear_regression.case1.chart_price_vs_age'),
                        'regressionLabel'=> __t('linear_regression.case1.chart_regression_label'),
                        'chartId'        => 'agePriceChart',
                        'minX'         => 0,
                        'minY'         => 0,
                        'showPrediction' => true,
                        'predictionX'    => 12,
                    ],
                ];

                foreach ($charts as $index => $cfg) {
                    // Show only the selected chart
                    if ($index !== $selectedChartIndex) {
                        continue;
                    }

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
                        showLegend: true,
                    );
                }
            ?>
        </div>
        <div class="col-md-12 col-lg-5 p-0 m-0">
            <div>
                <div>
                    <b><?= __t('linear_regression.case1.controls_chart_type'); ?>:</b>
                </div>
                <form class="mt-2" action="<?= APP_URL ?>part-2/linear-regression-as-basic-model/case-1/apartment-valuation-based-on-parameters/code-run" type="GET">
                    <?= create_form_features($chartTypeOptions, [$chartType], fieldName: 'chartTypes', type: 'select', class: 'w-30 me-4'); ?>
                    <div class="form-check form-check-inline float-end p-0 m-0 me-1">
                        <button type="submit" class="btn btn-sm btn-outline-primary"><?= __t('common.regenerate'); ?></button>
                    </div>
                    <div class=" clearfix "></div>
                </form>
            </div>
            <hr>

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
