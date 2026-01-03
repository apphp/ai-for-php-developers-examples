<?php

// A simple implementation of MSE (Mean Squared Error).
// We pass in two arrays of the same length:
// $y    — true values (ground‑truth observations),
// $yHat — values predicted by the model.
// The function returns a single number: the average squared error over all observations.
function mse(array $y, array $yHat): float {
    $n = count($y);

    $sum = 0.0;

    for ($i = 0; $i < $n; $i++) {
        $diff = $y[$i] - $yHat[$i];

        $sum += $diff * $diff;
    }

    return $sum / $n;
}
