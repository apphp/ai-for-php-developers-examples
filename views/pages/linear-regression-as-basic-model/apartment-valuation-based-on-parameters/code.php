<?php

function dotProduct(array $a, array $b): float {
    $sum = 0.0;
    foreach ($a as $i => $v) {
        $sum += $v * $b[$i];
    }
    return $sum;
}

// X: [площадь, этаж, расстояние до центра, возраст дома, bias]
$X = [
    [50, 3, 5, 10, 1],
    [70, 10, 3, 5, 1],
    [40, 2, 8, 30, 1],
];

// Цена в долларах
$y = [
    66_000,
    95_000,
    45_000,
];

$weights = array_fill(0, 5, 0.0);
$learningRate = 0.000001;
$epochs = 5000;

$n = count($X);
$m = count($weights);

for ($epoch = 0; $epoch < $epochs; $epoch++) {
    $gradients = array_fill(0, $m, 0.0);

    for ($i = 0; $i < $n; $i++) {
        $prediction = dotProduct($weights, $X[$i]);
        $error = $y[$i] - $prediction;

        for ($j = 0; $j < $m; $j++) {
            $gradients[$j] += -2 * $X[$i][$j] * $error;
        }
    }

    for ($j = 0; $j < $m; $j++) {
        $weights[$j] -= $learningRate * ($gradients[$j] / $n);
    }
}

$newApartment = [60, 5, 4, 12, 1];
$predictedPrice = dotProduct($weights, $newApartment);

echo "Оценка стоимости: $" . number_format($predictedPrice) . "\n";

// Результат:
// Оценка стоимости: $78,374
