<?php

use Rubix\ML\Classifiers\LogisticRegression;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;

// Each sample represents an email.
// Features: [subject length (tokens), number of links in the message body]
$samples = [
    [3, 1],   // short subject, few links
    [15, 8],  // long subject, many links
    [5, 0],   // medium subject, no links
];

// Class labels for each email: inbox mail vs spam
$labels = ['normal', 'spam', 'normal'];

// Supervised training dataset: feature vectors + class labels
$dataset = new Labeled($samples, $labels);

// Logistic regression classifier from RubixML
$model = new LogisticRegression();

// Train the classifier on the labeled dataset
$model->train($dataset);

// New incoming email we want to classify
// Same feature schema: [subject length, number of links]
$sample = new Unlabeled([[12, 6]]);

// Predicted probability for each class (e.g. ['normal' => 0.32, 'spam' => 0.68])
$probabilities = $model->proba($sample)[0];
