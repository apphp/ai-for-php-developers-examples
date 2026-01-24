<?php

include __DIR__ . '/code.php';

// Классификация нового объекта по наивному Байесу
$input = ['from_ads' => true, 'has_account' => true];

$scores = [];

foreach ($classCounts as $class => $count) {
    // Логарифм априорной вероятности класса
    $logProb = log($count / count($data));

    foreach ($input as $feature => $value) {
        // Простое сглаживание: если сочетание не встречалось, берём 1
        $featureCount = $featureCounts[$class][$feature][$value] ?? 1;
        $total = $classCounts[$class];
        $logProb += log($featureCount / $total);
    }

    $scores[$class] = $logProb;
}

arsort($scores);
print_r($scores);

