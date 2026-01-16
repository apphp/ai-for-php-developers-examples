<?php

require_once __DIR__ . '/code.php';

// Ground-truth labels for a binary classification task (1 = positive class).
$yTrue = [1, 0, 1, 0, 1];

// Scenario A: classifier is fairly confident and mostly correct.
$probsA = [0.95, 0.10, 0.90, 0.20, 0.85];

// Scenario B: classifier gives similar class predictions by threshold 0.5,
// but with much less calibrated probabilities (overconfident on mistakes).
$probsB = [0.55, 0.05, 0.6, 0.1, 0.51];

$logLossA = logLoss($yTrue, $probsA);
$logLossB = logLoss($yTrue, $probsB);

echo 'Log loss (model A, more confident and accurate): ' . round($logLossA, 4) . PHP_EOL;
echo 'Log loss (model B, less confident): ' . round($logLossB, 4) . PHP_EOL;
