<?php

// Default values or values from GET parameters
$gradientDebug ??= false;
$learningRateValue ??= 0.0001;
$epochsValue ??= 5000;
$debugResult = '';

// Dot product of two vectors
// Used to compute the prediction: ŷ = w · x
function dot(array $a, array $b): float {
    $sum = 0.0;
    foreach ($a as $i => $v) {
        $sum += $v * $b[$i];
    }
    return $sum;
}

// Feature matrix X
// Each row is a single sample (data point)
// First element is the real feature (area)
// Second element is always 1 — bias term included as a feature
$X = [
    [30, 1],
    [40, 1],
    [50, 1],
    [60, 1],
];

// True targets (dependent variable)
$y = [3, 4, 5, 6];

// Weight vector of the model
// w[0] — weight for area
// w[1] — weight for bias (intercept)
$w = [0.0, 0.0];

// Training hyperparameters
$learningRate = $learningRateValue;
$epochs = $epochsValue;
$n = count($X);

// Gradient descent
for ($epoch = 0; $epoch < $epochs; $epoch++) {

    // Gradient vector for each weight
    $dw = [0.0, 0.0];

    // Loop over all samples
    for ($i = 0; $i < $n; $i++) {

        // Prediction: dot product of weights and features
        $yPred = dot($w, $X[$i]);

        // Model error on the current sample
        $error = $y[$i] - $yPred;

        // Update gradients for each weight
        // ∂L/∂w_j = -2 * x_j * (y - ŷ)
        foreach ($dw as $j => $_) {
            $dw[$j] += -2 * $X[$i][$j] * $error;
        }
    }

    // Update weights by moving against the gradient
    foreach ($w as $j => $_) {
        $w[$j] -= $learningRate * ($dw[$j] / $n);

        if ($gradientDebug) {
            $debugResult .= "w = {$w[0]}, b = {$w[1]}\n";
        }
    }
}

// Final model weights
echo "w = {$w[0]}, b = {$w[1]}\n";
