<?php

use Rubix\ML\Classifiers\LogisticRegression;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Datasets\Labeled;

// One feature per user: time spent on the site.
$samples = [
    [0.5],
    [1.2],
    [2.0],
    [5.0],
    [7.0],
];

// Labels: subscribed or not.
$labels = ['no', 'no', 'no', 'yes', 'yes'];

$dataset = new Labeled($samples, $labels);

$model = new LogisticRegression();
$model->train($dataset);

// Predict for a new user (3.0 time units).
$prediction = new Unlabeled([[3.0]]);
$labels = $model->predict($prediction);

echo "Predicted label: ";
print_r($labels);

// Show probabilities
$probas = $model->proba($prediction);
echo "\nProbabilities (per class): ";
print_r($probas[0]);
