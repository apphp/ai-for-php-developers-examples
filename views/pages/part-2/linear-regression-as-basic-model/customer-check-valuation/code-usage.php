<?php

use Rubix\ML\Datasets\Unlabeled;

require_once __DIR__ . '/code.php';

// Customer features for prediction
// [visits, time_on_site_seconds, pageviews, discount_percent]
$customer = [5, 600, 8, 5];

$unlabeled = new Unlabeled([$customer]);
$logPrice = $model->predict($unlabeled);
$predictedPrice = exp($logPrice[0]);

$weights = $model->coefficients();
$bias = $model->bias();

echo 'Predicted check: ' . round($predictedPrice, 2) . PHP_EOL;
echo 'Predicted log(check): ' . round($logPrice[0], 6) . PHP_EOL . PHP_EOL;

echo 'Coefficients (feature weights):' . PHP_EOL;
echo '0 - visits, 1 - time_on_site_seconds, 2 - pageviews, 3 - discount_percent' . PHP_EOL;
print_r($weights);

echo PHP_EOL . 'Bias (intercept): ' . $bias . PHP_EOL;
