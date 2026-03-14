<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Regressors\Ridge;

// Training samples: each row is a completed task with its feature vector
// x = (x1, x2, x3, x4):
// [story_points (x1), files_changed (x2), lines_changed (x3), developer_experience (x4)]
$samples = [
    [5, 3, 200, 24],
    [8, 5, 500, 12],
    [3, 1, 100, 36],
];

// Target values: actual completion time in hours for each task above
$labels = [
    6.5,  // hours for task 1
    12.0, // hours for task 2
    4.0,  // hours for task 3
];

// Build a labeled dataset (features X + targets y)
$dataset = new Labeled($samples, $labels);

// Ridge regression: linear regression with L2 regularization
// With a tiny alpha (1e-6) it behaves almost like ordinary least squares.
$model = new Ridge(1e-6);

// Train the model
$model->train($dataset);

$newTask = [6, 4, 300, 18];
$unlabeled = new Unlabeled([$newTask]);
$predictions = $model->predict($unlabeled);

$weights = $model->coefficients();
$bias = $model->bias();

echo 'Estimated task completion time: ' . round($predictions[0], 1) . 'h' . PHP_EOL . PHP_EOL;

echo 'Coefficients (feature weights):' . PHP_EOL;
echo '0 - story_points, 1 - files_changed, 2 - lines_changed, 3 - developer_experience' . PHP_EOL;
print_r($weights);

echo PHP_EOL . 'Bias (intercept): ' . $bias . PHP_EOL;
