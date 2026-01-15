<?php

require_once __DIR__ . '/code.php';

// Observed (actual) target values from your dataset
$y = [10, 12, 15, 14, 13];

// Predicted values produced by model A for the same inputs
$modelA = [9, 11, 14, 13, 12];

// Predicted values produced by model B for the same inputs
$modelB = [10, 13, 15, 15, 14];

// Compute and print the Mean Squared Error (MSE) for each model.
// The model with the lower MSE is considered to fit the data better.
echo "MSE A: " . mse($y, $modelA) . PHP_EOL;
echo "MSE B: " . mse($y, $modelB) . PHP_EOL;
