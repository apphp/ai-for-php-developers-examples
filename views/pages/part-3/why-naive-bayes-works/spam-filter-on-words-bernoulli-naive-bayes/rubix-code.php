<?php

use Rubix\ML\Classifiers\NaiveBayes;
use Rubix\ML\Datasets\Labeled;

// We align the feature space with the pure PHP example by using the same vocabulary:
// [free, win, meeting, project]
//
// Note: RubixML NaiveBayes expects categorical (discrete) features.
// We represent our binary presence/absence values as strings '0'/'1' (categories),
// not as numeric 0/1 (which may be treated as continuous).
$samples = [
    // ['free', 'win', 'meeting', 'project']
    ['1', '1', '0', '0'],
    ['1', '0', '0', '0'],
    ['0', '0', '1', '0'],
    ['0', '0', '0', '1'],
];

// Class labels for each email.
$labels = ['spam', 'spam', 'ham', 'ham'];

// Build the labeled dataset and train Naive Bayes.
$dataset = new Labeled($samples, $labels);

$model = new NaiveBayes();
$model->train($dataset);
