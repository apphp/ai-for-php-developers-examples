<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Regressors\Ridge;

// Features: visits, time_on_site_seconds, pageviews, discount_percent
$samples = [
    [3, 420, 5, 0],
    [10, 1800, 20, 10],
    [1, 120, 2, 0],
    [7, 900, 12, 5],
];

// Target: log(check_amount)
$labels = [
    log(3500),
    log(12000),
    log(1800),
    log(7200),
];

$dataset = Labeled::build($samples, $labels);

// Ridge regression (L2 regularization)
// With a tiny alpha (1e-6) it behaves almost like ordinary least squares.
$model = new Ridge(1e-6);
$model->train($dataset);
