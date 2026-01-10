<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Regressors\Ridge;

// Data: [area, floor, distance to city center, building age]
$samples = [
    [50, 3, 5, 10],
    [70, 10, 3, 5],
    [40, 2, 8, 30],
];

$targets = [
    66_000,
    95_000,
    45_000,
];

// Create labeled dataset
$dataset = new Labeled($samples, $targets);

// Create linear regression model (Ridge)
$regression = new Ridge(1.0);

// Train the model
$regression->train($dataset);

// Make a prediction for a new apartment
// [square footage, number of bedrooms, number of bathrooms, number of floors]
$newApartment = [60, 5, 4, 12];

// Ridge::predict expects a Dataset and returns an array of predictions
$dataset = new Unlabeled([$newApartment]);
$predictions = $regression->predict($dataset);
$predictedPrice = $predictions[0];

echo 'Apartment valuation: $' . number_format($predictedPrice) . "\n";
