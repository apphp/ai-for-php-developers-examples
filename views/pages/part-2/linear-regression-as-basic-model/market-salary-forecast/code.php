<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Regressors\Ridge;

// Features: experience_years, technologies_score, company_size_level, remote
$samples = [
    [1, 2, 1, 1],
    [3, 4, 2, 1],
    [5, 6, 3, 0],
    [7, 8, 3, 1],
    [10, 10, 3, 1],
];

// Target: salary_usd
$labels = [
    1500,
    2800,
    4500,
    6200,
    8000,
];

$dataset = Labeled::build($samples, $labels);

$model = new Ridge(1.0);
$model->train($dataset);
