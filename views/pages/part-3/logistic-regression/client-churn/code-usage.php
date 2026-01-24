<?php

include __DIR__ . '/code.php';

// Describe a new user with the same feature structure as rows in $X.
// For example: three behavioral / profile metrics.
$newUser = [5.0, 7.0, 120.0];

// Compute the churn probability for this user:
// 1) linear score z = w · x + b
// 2) pass through sigmoid to get a probability in (0, 1).
$probability = sigmoid(dot($weights, $newUser) + $bias);

// Print the final probability (rounded) to the console / page.
echo 'Churn probability: ' . round($probability, 3) . PHP_EOL;
