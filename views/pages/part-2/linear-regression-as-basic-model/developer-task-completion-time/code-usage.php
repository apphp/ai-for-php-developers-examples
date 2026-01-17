<?php

use Rubix\ML\Datasets\Unlabeled;

require_once __DIR__ . '/code.php';

$newTask = [6, 4, 300, 18];
$unlabeled = new Unlabeled([$newTask]);
$predictions = $model->predict($unlabeled);

$weights = $model->coefficients();
$bias = $model->bias();

echo "Estimated task completion time: " . round($predictions[0], 1) . "h" . PHP_EOL . PHP_EOL;

echo "Coefficients (feature weights):\n";
echo "0 - story_points, 1 - files_changed, 2 - lines_changed, 3 - developer_experience" . PHP_EOL;
print_r($weights);

echo "\nBias (intercept): " . $bias . "\n";
