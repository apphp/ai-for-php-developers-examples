<?php

// This file is the runnable version used by the "code-run" page.
// We keep the core functions and dataset in code.php and only execute the experiment here.
include('code.php');

// Feature indices: 0 = visits, 1 = time
$featureIndex = 0;

// Use all unique values of the chosen feature as candidate thresholds.
// (This is a simple brute-force approach suitable for a tutorial example.)
$values = array_unique(array_column($data, $featureIndex));
sort($values);

// Track the best split we have seen so far.
$bestGain = 0.0;
$bestThreshold = null;
$bestSplit = null;

foreach ($values as $threshold) {
    [$left, $right] = split($data, $featureIndex, $threshold);

    // Skip degenerate splits (when everything goes to one side).
    if (empty($left) || empty($right)) {
        continue;
    }

    $gain = informationGain($data, $left, $right);

    if ($gain > $bestGain) {
        $bestGain = $gain;
        $bestThreshold = $threshold;
        $bestSplit = [$left, $right];
    }
}

// Output the best split (threshold + information gain) and show the resulting branches.
echo 'Best split:' . PHP_EOL;
echo 'Feature: visits' . PHP_EOL;
echo "Threshold: $bestThreshold" . PHP_EOL;
echo "Information Gain: $bestGain" . PHP_EOL . PHP_EOL;

echo 'Left branch:' . PHP_EOL;
echo array_to_matrix($bestSplit[0]) . PHP_EOL;

echo PHP_EOL . 'Right branch:' . PHP_EOL;
echo array_to_matrix($bestSplit[1]);
