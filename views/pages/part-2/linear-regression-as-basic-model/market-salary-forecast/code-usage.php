<?php

use Rubix\ML\Datasets\Unlabeled;

require_once __DIR__ . '/code.php';

// Candidate features for prediction
// [experience_years, technologies_score, company_size_level, remote]
$candidate = [4, 5, 2, 1];

$unlabeled = new Unlabeled([$candidate]);
$prediction = $model->predict($unlabeled);

$salary = $prediction[0];

$weights = array_map( function ($weight) {
    return number_format($weight, 2);
}, $model->coefficients());
$bias = number_format($model->bias(), 2);

echo 'Expected salary: ' . round($salary, 2) . PHP_EOL . PHP_EOL;

echo 'Coefficients (feature weights):' . PHP_EOL;
echo '0 - experience_years, 1 - technologies_score, 2 - company_size_level, 3 - remote' . PHP_EOL;
print_r($weights);

echo PHP_EOL . 'Bias (intercept): ' . $bias . PHP_EOL;
