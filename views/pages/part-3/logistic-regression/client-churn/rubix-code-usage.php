<?php

use Rubix\ML\Datasets\Unlabeled;

include __DIR__ . '/rubix-code.php';

// Describe a new user with the same feature structure as the training samples.
$newUser = [5, 7, 120];

// Build an Unlabeled dataset from a single user example.
$dataset = new Unlabeled([$newUser]);

// Ask the classifier for class probabilities instead of hard labels.
$probabilities = $classifier->proba($dataset);

// Take the first (and only) prediction row.
$probaRow = $probabilities[0];

// Probability of churn (for class 'churn').
$churnProbability = $probaRow['churn'];

echo 'Churn probability (RubixML): ' . number_format($churnProbability, 3) . PHP_EOL;
