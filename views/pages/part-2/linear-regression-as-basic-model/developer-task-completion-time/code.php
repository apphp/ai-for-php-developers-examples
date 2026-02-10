<?php

use Rubix\ML\Datasets\Labeled;
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
// With alpha = 1e-6, Ridge regression is equivalent to linear regression
$model = new Ridge(1e-6);

// Train the model
$model->train($dataset);
