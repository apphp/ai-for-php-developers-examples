<?php

require_once __DIR__ . '/code.php';

/**
 * Training dataset for a simple 1D regression example.
 *
 * Each row is: [x, yTrue]
 *
 * @var array<int, array{0: float, 1: float}> $dataset
 */
$dataset = [
    [1.0, 2.0],
    [2.0, 4.0],
];

/**
 * Format a float value for prettier output.
 *
 * - If the number is effectively an integer (e.g. 2.0), print it as "2".
 * - Otherwise print a trimmed decimal representation.
 *
 * @param float $value
 * @return string
 */
$formatNumber = function (float $value): string {
    $asInt = (int)$value;

    return ($value === (float)$asInt) ? (string)$asInt : rtrim(rtrim(number_format($value, 10, '.', ''), '0'), '.');
};

// Плохая модель (до обучения)
$model = new LinearModel(w: 0.0, b: 0.0);

foreach ($dataset as [$x, $yTrue]) {
    $yPredicted = $model->predict($x);
    $loss = squaredError($yTrue, $yPredicted);

    echo 'x = ' . $formatNumber($x) . ', yTrue = ' . $formatNumber($yTrue) . ', yPredicted = ' . $formatNumber($yPredicted) . ', loss = ' . $formatNumber($loss) . PHP_EOL;
}

echo PHP_EOL;

// Improved model (after several "training steps")
$model = new LinearModel(w: 0.8, b: 0.0);

foreach ($dataset as [$x, $yTrue]) {
    $yPredicted = $model->predict($x);
    $loss = squaredError($yTrue, $yPredicted);

    echo 'x = ' . $formatNumber($x) . ', yTrue = ' . $formatNumber($yTrue) . ', yPredicted = ' . $formatNumber($yPredicted) . ', loss = ' . $formatNumber($loss) . PHP_EOL;
}
