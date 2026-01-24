<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\NaiveBayes;

// Категориальные признаки закодированы как 0/1.
// from_ads: 1 или 0; has_account: 1 или 0.
$samples = [
    [1, 1],
    [0, 1],
    [1, 0],
    [1, 0],
];

// Метки классов для каждой строки.
$labels = ['buyer', 'buyer', 'browser', 'browser'];

// Собираем обучающую выборку.
$dataset = new Labeled($samples, $labels);

// Модель наивного Байеса из RubixML.
$model = new NaiveBayes();
$model->train($dataset);

