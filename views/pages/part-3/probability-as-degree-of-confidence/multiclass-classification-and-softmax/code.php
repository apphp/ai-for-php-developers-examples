<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Classifiers\SoftmaxClassifier;

// Email features: [subject length, number of links]
$samples = [
    [4, 0],
    [6, 1],
    [10, 3],
    [12, 4],
    [15, 7],
    [18, 9],
];

// Class labels for the training samples
$labels = [
    'normal',
    'normal',
    'promo',
    'promo',
    'spam',
    'spam',
];

// Build a labeled dataset from features and labels
$dataset = new Labeled($samples, $labels);

// Softmax produces a probability distribution over classes
$model = new SoftmaxClassifier();
// Train the model on the prepared dataset
$model->train($dataset);

