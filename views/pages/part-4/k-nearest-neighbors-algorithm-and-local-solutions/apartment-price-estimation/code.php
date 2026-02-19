<?php

// k-Nearest Neighbors (k-NN) for regression: estimate apartment price.
function euclideanDistance(array $a, array $b): float {
    // Euclidean distance between two vectors (points).
    $sum = 0.0;

    foreach ($a as $i => $value) {
        $sum += ($value - $b[$i]) ** 2;
    }

    return sqrt($sum);
}

// Dataset:
// Each item is [features, price].
// Here features are [area_m2, distance_to_center_km] and price is a numeric value.
$dataset = [
    [[40, 12], 120000],
    [[50, 10], 150000],
    [[60, 8], 190000],
    [[70, 6], 240000],
    [[80, 5], 300000],
];

// Apartment we want to price.
$query = [65, 7];

// How many nearest neighbors to use.
$k = 3;

$distances = [];

foreach ($dataset as [$features, $price]) {
    $distances[] = [
        'distance' => euclideanDistance($features, $query),
        'price' => $price,
    ];
}

usort($distances, fn ($a, $b) => $a['distance'] <=> $b['distance']);

$neighbors = array_slice($distances, 0, $k);

$sum = 0;

foreach ($neighbors as $neighbor) {
    $sum += $neighbor['price'];
}

$prediction = $sum / $k;
