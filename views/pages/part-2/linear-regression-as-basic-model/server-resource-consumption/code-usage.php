<?php

use Rubix\ML\Datasets\Unlabeled;

require_once __DIR__ . '/code.php';

// Future metrics for which we want to forecast CPU load
// [requests_per_min, avg_response_size_kb, active_users, cron_jobs, hour]
$futureMetrics = [1000, 12, 250, 10, 16];

$unlabeled = new Unlabeled([$futureMetrics]);
$predictions = $model->predict($unlabeled);

// Model parameters
$weights = $model->coefficients();
$bias = $model->bias();

echo 'Expected CPU load: ' . round($predictions[0], 1) . '%' . PHP_EOL . PHP_EOL;

echo 'Coefficients (feature weights):' . PHP_EOL;
echo '0 - requests_per_min, 1 - avg_response_size_kb, 2 - active_users, 3 - cron_jobs, 4 - hour' . PHP_EOL;
print_r($weights);

echo PHP_EOL . 'Bias (intercept): ' . $bias . PHP_EOL;
