<?php

$gradientDebug ??= false;
$debugResult = '';

// Training data
$x = [30, 40, 50, 60]; // area in m²
$y = [3, 4, 5, 6];     // price (arbitrary units)

// Model parameters
$w = 0.0; // weight
$b = 0.0; // bias

// Training hyperparameters
$learningRate = 0.0001;
$epochs = 5000;
$n = count($x);

// Gradient descent
for ($epoch = 0; $epoch < $epochs; $epoch++) {

    // Accumulated gradients
    $dw = 0.0;
    $db = 0.0;

    // Iterate over all data points
    for ($i = 0; $i < $n; $i++) {
        // Model prediction
        $yPred = $w * $x[$i] + $b;

        // Prediction error
        // If the error is positive – the model underestimates
        // If the error is negative – the model overestimates
        $error = $y[$i] - $yPred;

        // Derivatives of MSE with respect to w and b
        $dw += -2 * $x[$i] * $error;
        $db += -2 * $error;
    }

    // Average the gradients
    // We compute the average gradient over all points instead of updating after each one.
    // This is classic batch gradient descent.
    $dw /= $n;
    $db /= $n;

    // Update model parameters — gradient descent step
    // We move against the direction of the gradient, because the gradient points where the error increases.
    // A small step leads to more stable training.
    $w -= $learningRate * $dw;
    $b -= $learningRate * $db;

    if ($gradientDebug) {
        $debugResult .= "w = {$w}, b = {$b}\n";
    }
}

echo "w = {$w}, b = {$b}\n";
