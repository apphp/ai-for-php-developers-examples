<?php

// k-Nearest Neighbors (k-NN) from scratch: runnable version used by the "code-run" page.
function euclideanDistance(array $a, array $b): float {
    // Euclidean distance between two vectors (points).
    $sum = 0.0;

    foreach ($a as $i => $value) {
        $sum += ($value - $b[$i]) ** 2;
    }

    return sqrt($sum);
}

// Training dataset:
// Each item is [features, label].
// In a real project, features could be session count, time in product, spend, etc.
$dataset = [
    [[5, 2.1], 'casual'],
    [[3, 1.8], 'casual'],
    [[10, 6.5], 'engaged'],
    [[12, 7.0], 'engaged'],
    [[9, 5.8], 'engaged'],
];

// A new customer we want to classify.
$query = [8, 5.5];

// How many nearest neighbors to use.
$k = 3;

// Compute distances from the query point to each dataset point.
$distances = [];

foreach ($dataset as [$point, $label]) {
    $distances[] = [
        'distance' => euclideanDistance($point, $query),
        'label' => $label,
    ];
}

// Sort by distance (nearest first) and take k closest samples.
usort($distances, fn ($a, $b) => $a['distance'] <=> $b['distance']);
$neighbors = array_slice($distances, 0, $k);

// Debug output: show k nearest neighbors (distance + label).
echo 'Neighbors: ' . PHP_EOL . array_to_matrix($neighbors) . PHP_EOL . PHP_EOL;

// Majority vote among the neighbors' labels.
$votes = [];

foreach ($neighbors as $neighbor) {
    $votes[$neighbor['label']] = ($votes[$neighbor['label']] ?? 0) + 1;
}

// Pick the label with the highest vote count.
arsort($votes);
$prediction = array_key_first($votes);

echo "Prediction: $prediction";
