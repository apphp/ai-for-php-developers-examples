<?php

function train(float $lr, array $x, array $y): array {
    // Start with an initial weight and track how it changes each epoch.
    $w = 0.0;
    $n = count($x);
    $trajectory = [];

    echo PHP_EOL . "Learning rate = $lr" . PHP_EOL;

    for ($epoch = 1; $epoch <= 10; $epoch++) {
        $gradient = 0.0;

        for ($i = 0; $i < $n; $i++) {
            // Compute prediction error for one training example.
            $error = ($w * $x[$i]) - $y[$i];
            $gradient += $x[$i] * $error;
        }

        // Convert the accumulated value into the mean squared error gradient.
        $gradient = (2 / $n) * $gradient;
        // Update the weight in the direction that reduces the loss.
        $w -= $lr * $gradient;
        // Store the rounded weight so the caller can visualize the path.
        $trajectory[] = [
            'epoch' => $epoch,
            'w' => round($w, 4),
        ];

        echo "Epoch $epoch: w = " . round($w, 4) . PHP_EOL;
    }

    return $trajectory;
}

// Simple training data where the target relationship is y = 2x.
$x = [1, 2, 3, 4];
$y = [2, 4, 6, 8];

$trajectories = [
    '0.01' => train(0.01, $x, $y),
    '0.1' => train(0.1, $x, $y),
    '1.0' => train(1.0, $x, $y),
];
