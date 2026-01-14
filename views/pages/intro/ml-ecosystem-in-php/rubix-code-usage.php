<?php

use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;

$samples = [
    [170, 65],
    [160, 50],
    [180, 80],
    [175, 70],
];

$labels = ['M', 'F', 'M', 'M'];

$dataset = new Labeled($samples, $labels);

$model = new KNearestNeighbors(3);
$model->train($dataset);

$testSamples = new Unlabeled([[172, 68]]);
$prediction = $model->predict($testSamples);

echo $prediction[0];
