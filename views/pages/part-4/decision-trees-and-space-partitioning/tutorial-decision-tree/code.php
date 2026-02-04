<?php

// A tiny toy dataset for a binary classification example.
// Each row is: [visits, time, label].
// - visits: number of visits (feature 0)
// - time: time spent (feature 1)
// - label: a simple segment ('active' / 'passive')

$data = [
    [5, 10, 'active'],
    [7, 15, 'active'],
    [1, 2, 'passive'],
    [2, 3, 'passive'],
    [6, 8, 'active'],
    [3, 4, 'passive'],
];

// Entropy measures how “mixed” the class labels are.
// If all labels are the same => entropy = 0.
// If labels are evenly split => entropy is higher.
function entropy(array $labels): float {
    $counts = array_count_values($labels);
    $total = count($labels);

    $entropy = 0.0;

    foreach ($counts as $count) {
        $p = $count / $total;
        $entropy -= $p * log($p, 2);
    }

    return $entropy;
}

// Information Gain (IG) shows how much entropy decreases after a split.
// IG = H(parent) - weightedAverage(H(left), H(right))
// A higher IG means the split separates the classes better.
function informationGain(array $parent, array $left, array $right): float {
    $parentLabels = array_column($parent, 2);
    $leftLabels = array_column($left, 2);
    $rightLabels = array_column($right, 2);

    $hParent = entropy($parentLabels);
    $hLeft = entropy($leftLabels);
    $hRight = entropy($rightLabels);

    $total = count($parent);

    $weighted = (count($left) / $total) * $hLeft + (count($right) / $total) * $hRight;

    return $hParent - $weighted;
}

// Split the dataset by a numeric feature and a threshold.
// Convention: values < threshold go to the left branch, otherwise to the right branch.
function split(array $data, int $featureIndex, float $threshold): array {
    $left = [];
    $right = [];

    foreach ($data as $row) {
        if ($row[$featureIndex] < $threshold) {
            $left[] = $row;
        } else {
            $right[] = $row;
        }
    }

    return [$left, $right];
}
