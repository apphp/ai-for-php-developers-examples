<?php

use Rubix\ML\Classifiers\LogisticRegression;
use Rubix\ML\Datasets\Labeled;

// Training samples: each row is a user described by 3 numeric features.
// In a real project these could be behavioral or profile metrics.
$samples = [
    [1, 5.2, 30],
    [12, 15.1, 400],
    [3, 4.8, 60],
    [20, 25.0, 800],
];

// Categorical labels for each user:
// 'churn'  — the user left,
// 'stay'   — the user remained active.
$labels = ['churn', 'stay', 'churn', 'stay'];

// Build a labeled dataset from samples and labels.
$dataset = new Labeled($samples, $labels);

// Create a logistic regression classifier with default settings
// and train it on the churn dataset.
$classifier = new LogisticRegression();
$classifier->train($dataset);
