<?php

// Compute the dot product of two vectors: sum(a_i * b_i)
function dotProduct(array $a, array $b): float {
    $sum = 0.0;
    foreach ($a as $i => $v) {
        $sum += $v * $b[$i];
    }
    return $sum;
}

// Training data: each row is an apartment described by features
// X: [area, floor, distance to city center, building age, bias]
$X = [
    [50, 3, 5, 10, 1],
    [70, 10, 3, 5, 1],
    [40, 2, 8, 30, 1],
];

// Target values: apartment prices in dollars
$y = [
    66_000,
    95_000,
    45_000,
];

// Initialize model parameters (weights) and training hyperparameters
$weights = array_fill(0, 5, 0.0);
$learningRate = 0.000001;
$epochs = 5_000;

// n — number of training examples, m — number of features (including bias)
$n = count($X);
$m = count($weights);

// Gradient descent loop: repeat several passes over the dataset
for ($epoch = 0; $epoch < $epochs; $epoch++) {
    // Accumulate gradients for each weight over the whole dataset
    $gradients = array_fill(0, $m, 0.0);

    for ($i = 0; $i < $n; $i++) {
        // Model prediction: y_hat = w · x
        $prediction = dotProduct($weights, $X[$i]);
        // Error for this example: true - predicted
        $error = $y[$i] - $prediction;

        // Accumulate gradient for each weight (derivative of MSE w.r.t. w_j)
        for ($j = 0; $j < $m; $j++) {
            $gradients[$j] += -2 * $X[$i][$j] * $error;
        }
    }

    // Gradient descent update: move weights against the average gradient
    for ($j = 0; $j < $m; $j++) {
        $weights[$j] -= $learningRate * ($gradients[$j] / $n);
    }
}
