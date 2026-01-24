<?php

$data = [
    ['class' => 'buyer',   'from_ads' => true,  'has_account' => true],
    ['class' => 'buyer',   'from_ads' => false, 'has_account' => true],
    ['class' => 'browser', 'from_ads' => true,  'has_account' => false],
    ['class' => 'browser', 'from_ads' => true,  'has_account' => false],
];

// Подсчет априорных вероятностей и условных частот признаков по классам
$classCounts = [];
$featureCounts = [];

foreach ($data as $row) {
    $class = $row['class'];
    $classCounts[$class] = ($classCounts[$class] ?? 0) + 1;

    foreach ($row as $feature => $value) {
        if ($feature === 'class') {
            continue;
        }

        $featureCounts[$class][$feature][$value] =
            ($featureCounts[$class][$feature][$value] ?? 0) + 1;
    }
}

