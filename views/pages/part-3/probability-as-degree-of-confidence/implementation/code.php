<?php

function softmax(array $scores): array {
    // For numerical stability we subtract the maximum score from all scores
    $max = max($scores);

    // Will store exp(score - max) for each label
    $expValues = [];
    // Sum of all exponentiated values, used to normalize into probabilities
    $sum = 0.0;

    // Compute exponentials in a numerically stable way and accumulate their sum
    foreach ($scores as $key => $value) {
        // Shift score by subtracting $max to avoid very large exponentials
        $exp = exp($value - $max);
        $expValues[$key] = $exp;
        $sum += $exp;
    }

    // Normalize each exponential by the total sum to get a probability for each label
    $probabilities = [];

    foreach ($expValues as $key => $value) {
        // Guard with max($sum, 1) so we never divide by zero
        $probabilities[$key] = $value / max($sum, 1);
    }

    // Result: associative array mapping label => probability
    return $probabilities;
}
