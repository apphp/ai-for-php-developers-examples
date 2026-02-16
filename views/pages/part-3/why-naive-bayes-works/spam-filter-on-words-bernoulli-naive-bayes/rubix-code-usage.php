<?php

use Rubix\ML\Datasets\Unlabeled;

include __DIR__ . '/rubix-code.php';

// Predict for input: [free, win, meeting, project] = [1, 0, 1, 0]
$dataset = new Unlabeled([
    ['1', '0', '1', '0'],
]);

$prediction = $model->predict($dataset);
print_r($prediction);
