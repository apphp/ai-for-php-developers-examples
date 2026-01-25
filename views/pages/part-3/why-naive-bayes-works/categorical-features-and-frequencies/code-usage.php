<?php

include __DIR__ . '/code.php';

// Classify a new sample using Naive Bayes.
$input = ['from_ads' => true, 'has_account' => true];

// We will store a score for each class (log-probability).
$scores = [];

foreach ($classCounts as $class => $count) {
    // Start with the log prior: log P(class).
    $logProb = log($count / count($data));

    foreach ($input as $feature => $value) {
        // Booleans become 0/1 keys in PHP arrays.
        $valueKey = (int)$value;

        // Count how often feature=value occurs in this class.
        $featureCount = $featureCounts[$class][$feature][$valueKey] ?? 0;
        $total = $classCounts[$class];

        // Add log P(feature=value | class) using Laplace smoothing:
        // (count + 1) / (total + K), where K is number of possible values.
        // Here K=2 because the feature is boolean.
        $logProb += log(($featureCount + 1) / ($total + 2));
    }

    // Final score for this class.
    $scores[$class] = $logProb;
}

// Highest score (closest to 0) corresponds to the most likely class.
// The first array key after sorting is the predicted class.
arsort($scores);

// Print raw scores for inspection.
print_r($scores);
