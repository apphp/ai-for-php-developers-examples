<?php

use Rubix\ML\Classifiers\ClassificationTree;
use Rubix\ML\Datasets\Labeled;

// Our tiny training dataset
// Each sample is a 2D numeric vector: [visits, time]
$samples = [
    [5, 10],
    [7, 15],
    [1, 2],
    [2, 3],
    [6, 8],
    [3, 4],
];

// Class labels for each row in $samples
$labels = ['active', 'active', 'passive', 'passive', 'active', 'passive'];

// Wrap the arrays into a RubixML Labeled dataset.
$dataset = new Labeled($samples, $labels);

// Create a decision tree classifier
$estimator = new ClassificationTree(
    maxHeight: 3,
    maxLeafSize: 2
);

// Fit the model
$estimator->train($dataset);

