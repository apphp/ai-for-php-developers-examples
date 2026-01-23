<?php

// Sigmoid activation: maps any real value to (0, 1),
// which we interpret as a probability of churn.
function sigmoid(float $z): float {
    return 1.0 / (1.0 + exp(-$z));
}

// Dot product between two equal‑length vectors.
function dot(array $a, array $b): float {
    $sum = 0.0;

    foreach ($a as $i => $v) {
        $sum += $v * $b[$i];
    }

    return $sum;
}

// Toy dataset: each row is a user described by 3 numeric features.
// For example, they might represent simple behavioral or profile metrics.
$X = [
    [1.0, 5.2, 30.0],
    [12.0, 15.1, 400.0],
    [3.0, 4.8, 60.0],
    [20.0, 25.0, 800.0],
];

// Binary labels: 1 – user churned, 0 – user stayed.
$y = [1, 0, 1, 0];

// Model parameters: 3 weights (one per feature) and a scalar bias term.
$weights = [0.0, 0.0, 0.0];
$bias = 0.0;

// Training hyperparameters: learning rate and number of epochs.
$learningRate = 0.01;
$epochs = 1000;

// Stochastic gradient descent over the dataset.
for ($epoch = 0; $epoch < $epochs; $epoch++) {
    foreach ($X as $i => $x) {
        // Linear score z = w · x + b.
        $z = dot($weights, $x) + $bias;
        // Predicted probability of churn via sigmoid.
        $p = sigmoid($z);

        // Gradient of log-loss w.r.t. z for this example: (p - y).
        $error = $p - $y[$i];

        // Gradient step for each weight parameter.
        foreach ($weights as $j => $w) {
            $weights[$j] -= $learningRate * $error * $x[$j];
        }

        // Gradient step for the bias term.
        $bias -= $learningRate * $error;
    }
}
