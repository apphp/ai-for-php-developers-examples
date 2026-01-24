<?php

// Toy training dataset: each row is a sample with two boolean features and a class label.
$data = [
    ['class' => 'buyer',   'from_ads' => true,  'has_account' => true],
    ['class' => 'buyer',   'from_ads' => false, 'has_account' => true],
    ['class' => 'browser', 'from_ads' => true,  'has_account' => false],
    ['class' => 'browser', 'from_ads' => true,  'has_account' => false],
];

// Count priors (class frequencies) and conditional feature frequencies per class.
// These counts will be used later to compute P(class) and P(feature=value | class).
$classCounts = [];
$featureCounts = [];

foreach ($data as $row) {
    // Count how many samples belong to each class.
    $class = $row['class'];
    $classCounts[$class] = ($classCounts[$class] ?? 0) + 1;

    foreach ($row as $feature => $value) {
        if ($feature === 'class') {
            continue;
        }

        // Count how often each feature value occurs within each class.
        // Note: in PHP array keys, booleans are cast to 0/1.
        $featureCounts[$class][$feature][$value] = ($featureCounts[$class][$feature][$value] ?? 0) + 1;
    }
}
