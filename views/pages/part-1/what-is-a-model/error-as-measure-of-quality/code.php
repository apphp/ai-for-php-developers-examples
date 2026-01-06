<?php

// Simple error: difference between prediction and true value
// ŷ - y. Positive means we overestimated, negative means we underestimated.
function error(float $yTrue, float $yPredicted): float {
    return $yPredicted - $yTrue;
}

// Squared error: (ŷ - y)^2
// Always non‑negative and penalizes large mistakes more strongly than small ones.
function squaredError(float $yTrue, float $yPredicted): float {
    return ($yPredicted - $yTrue) ** 2;
}
