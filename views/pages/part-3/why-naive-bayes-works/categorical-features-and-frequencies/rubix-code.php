<?php

use Rubix\ML\Classifiers\NaiveBayes;
use Rubix\ML\Datasets\Labeled;

// Training samples for RubixML NaiveBayes.
// Important: Rubix\ML\Classifiers\NaiveBayes works with categorical (discrete) features.
$samples = [
    ['from_ads', 'has_account'],
    ['organic_search', 'has_account'],
    ['from_ads', 'no_account'],
    ['from_ads', 'no_account'],
];

// Class labels for each sample.
$labels = ['buyer', 'buyer', 'browser', 'browser'];

// Build the labeled dataset.
$dataset = new Labeled($samples, $labels);

// Train Naive Bayes model.
$model = new NaiveBayes();
$model->train($dataset);
