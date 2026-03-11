<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Regressors\Ridge;

// Training data for a simple relationship y = 2x.
$samples = [[1], [2], [3], [4]];
$labels = [2, 4, 6, 8];

// A labeled dataset pairs each sample with its target value.
$dataset = new Labeled($samples, $labels);

// Ridge is linear regression with L2 regularization.
// With a tiny alpha (1e-6) it behaves almost like ordinary least squares.
$model = new Ridge(1e-6);

// Train = fit the best parameters (weights) that minimize error.
$model->train($dataset);

$predictions = $model->predict(new Unlabeled([[5]]));

$coefficients = $model->coefficients();
$bestW = number_format($coefficients[0], 2, '.', '');
$bestLoss = number_format($model->bias(), 3, '.', '');

echo "Best w ≈ {$bestW}, loss ≈ {$bestLoss}\n";
echo "Predict for 5: ≈ "  . number_format($predictions[0], 7, '.', '');
