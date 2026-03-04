<?php

// Step size for a simple grid search over the weight parameter w.
define('W_STEP', 0.01);

// Model: ŷ = w · x
// For each input x_i we predict y_hat_i.
function predict(array $x, float $w): array {
    return array_map(fn ($xi) => $w * $xi, $x);
}

// Mean Squared Error (MSE):
// MSE = (1/n) * Σ (y_i - ŷ_i)^2
// This is the loss function we will minimize.
function mse(array $y, array $yHat): float {
    $sum = 0.0;
    $n = count($y);

    for ($i = 0; $i < $n; $i++) {
        $sum += ($y[$i] - $yHat[$i]) ** 2;
    }

    return $sum / $n;
}

// "Training" in this case is a brute-force search:
// try many values of w and pick the one that gives the smallest MSE.
function findBestW(array $x, array $y, float $from = 0.0, float $to = 3.0, float $step = W_STEP): array {
    $bestW = null;
    $bestLoss = INF;

    for ($w = $from; $w <= $to; $w += $step) {
        $yHat = predict($x, $w);
        $loss = mse($y, $yHat);

        // Keep the best parameter value we have seen so far.
        if ($loss < $bestLoss) {
            $bestLoss = $loss;
            $bestW = $w;
        }
    }

    return [
        'bestW' => $bestW,
        'bestLoss' => $bestLoss,
    ];
}
