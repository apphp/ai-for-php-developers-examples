<?php

$prior = 0.001;        // P(disease)
$sensitivity = 0.99;   // P(positive | disease)
$specificity = 0.95;   // P(negative | healthy)

$falsePositive = 1 - $specificity;  // P(negative | ealthy)

$posterior = ($sensitivity * $prior)
    / (($sensitivity * $prior) + ($falsePositive * (1 - $prior)));

echo "True positive cases: " . ($sensitivity * $prior) . PHP_EOL;
echo "False positive results: " . ($falsePositive * (1 - $prior)) . PHP_EOL;
echo "Probability: " . round($posterior, 4);
