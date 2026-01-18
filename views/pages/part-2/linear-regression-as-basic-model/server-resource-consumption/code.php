<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Regressors\Ridge;

// Training samples: each row is an observation window
// [requests_per_min, avg_response_size_kb, active_users, cron_jobs, hour]
$samples = [
    [1200, 15, 300, 15, 14],
    [800, 10, 200, 9, 2],
    [1500, 18, 450, 20, 19],
    [400, 8, 120, 5, 4],
];

// Target values: CPU load in percent for each window above
$targets = [
    75.0,
    40.0,
    82.0,
    25.0,
];

// Build a labeled dataset (features X + targets y)
$dataset = Labeled::build($samples, $targets);

// Simple linear regression (ordinary least squares)
$model = new Ridge(1.0);
$model->train($dataset);
