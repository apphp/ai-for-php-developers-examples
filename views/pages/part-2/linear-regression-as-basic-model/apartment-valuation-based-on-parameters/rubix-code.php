<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Regressors\Ridge;

// Data: [area, floor, distance to city center, building age]
$samples = [
    [50, 3, 5, 10],
    [70, 10, 3, 5],
    [40, 2, 8, 30],
];

$targets = [
    66_000,
    95_000,
    45_000,
];

// Создаём датасет
$dataset = new Labeled($samples, $targets);

// Create linear regression model (Ridge)
// With alpha = 1e-6, Ridge regression is equivalent to linear regression
$regression = new Ridge(1e-6);

// Train the model
$regression->train($dataset);
