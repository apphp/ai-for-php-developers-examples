<?php

require_once __DIR__ . '/code.php';

$features = [0.12, 0.85, 0.33, 0.67, 0.91, 0.44, 0.58, 0.76, 0.29, 0.50];

try {
    $result = predict($features);
    echo 'Model score: ' . round($result, 3) . PHP_EOL;

    // Result interpretation
    if ($result > 0.7) {
        echo 'High probability of a positive outcome';
    } elseif ($result > 0.4) {
        echo 'Medium probability';
    } else {
        echo 'Low probability';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
