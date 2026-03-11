<?php

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
