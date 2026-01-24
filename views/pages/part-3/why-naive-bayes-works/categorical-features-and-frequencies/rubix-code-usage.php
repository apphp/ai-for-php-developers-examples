<?php

use Rubix\ML\Datasets\Unlabeled;

include __DIR__ . '/rubix-code.php';

// New sample to classify (must use the same categorical encoding as during training).
$sample = ['from_ads', 'has_account'];

// RubixML expects samples to be wrapped into a Dataset object.
$dataset = new Unlabeled([$sample]);

// Predict class label.
$prediction = $model->predict($dataset);

// Print the predicted label.
print_r($prediction);
