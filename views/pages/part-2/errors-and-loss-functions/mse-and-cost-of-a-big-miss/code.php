<?php

// A simple implementation of MSE (Mean Squared Error).
// We pass in two arrays of the same length:
// $y    – true values (ground‑truth observations),
// $yHat – values predicted by the model.
// The function returns a single number: the average squared error over all observations.
function mse(array $y, array $yHat): float {
    $sum = 0.0;
    $n = count($y);

    if ($n === 0) {
        return 0.0;
    }

    for ($i = 0; $i < $n; $i++) {
        $sum += ($y[$i] - $yHat[$i]) ** 2;
    }

    return $sum / $n;
}
