<?php

require_once __DIR__ . '/code.php';

// Scenario 1. Data without an outlier
// The model predicts prices reasonably well, the errors are moderate.
$y = [100, 120, 130, 115, 125];
$yHat = [102, 118, 128, 117, 123];

// Compute MSE for "normal" data without strong anomalies.
echo 'Normal MSE: ' . mse($y, $yHat) . PHP_EOL;

// Scenario 2. Add an outlier (anomalous point):
// Imagine that our dataset now contains one very "weird" apartment — either a data error or a truly unusual object.
$y[] = 300;
$yHat[] = 130;

// Compute MSE again. A single outlier drastically increases the average error, showing how sensitive MSE is to large mistakes.
echo 'MSE with outlier: ' . mse($y, $yHat) . PHP_EOL;
