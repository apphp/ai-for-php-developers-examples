<?php

// Binary log loss implementation.
// $yTrue  – array of true labels (0 or 1).
// $yProb  – array of predicted probabilities P(y = 1).
// Returns average negative log-likelihood of the true labels.
function logLoss(array $y, array $p, float $eps = 1e-15): float {
    $loss = 0.0;
    $n = count($y);

    if ($n === 0) {
        return 0.0;
    }

    for ($i = 0; $i < $n; $i++) {
        $pi = max($eps, min(1 - $eps, $p[$i]));
        $loss += $y[$i] * log($pi) + (1 - $y[$i]) * log(1 - $pi);
    }

    return -$loss / $n;
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
