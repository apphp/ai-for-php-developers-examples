<?php

// Binary log loss implementation.
// $yTrue  — array of true labels (0 or 1).
// $yProb  — array of predicted probabilities P(y = 1).
// Returns average negative log-likelihood of the true labels.
function logLoss(array $yTrue, array $yProb): float {
    $n = count($yTrue);

    if ($n === 0) {
        return 0.0;
    }

    $eps = 1e-15; // small value to avoid log(0)
    $sum = 0.0;

    for ($i = 0; $i < $n; $i++) {
        $sum += logLossTerm($yTrue[$i], $eps, $yProb[$i]);
    }

    return $sum / $n;
}

/**
 * Get log loss term for a single sample.
 * @param $yTrue
 * @param float $eps
 * @param $yProb
 * @return float|int
 */
function logLossTerm($yTrue, float $eps, $yProb): int|float {
    $y = (int)$yTrue;
    $p = max($eps, min(1.0 - $eps, (float)$yProb));

    // For binary classification: -[y * log(p) + (1 - y) * log(1 - p)]
    return -($y * log($p) + (1 - $y) * log(1 - $p));
}
