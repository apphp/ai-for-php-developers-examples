<?php

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Regressors\Ridge;

// Данные: [площадь, этаж, расстояние до центра, возраст дома]
$samples = [
    [50, 3, 5, 10],
    [70, 10, 3, 5],
    [40, 2, 8, 30],
];

$targets = [
    66_000,
    95_000,
    45_000,
];

// Создаём датасет
$dataset = new Labeled($samples, $targets);

// Создаём модель линейной регрессии
$regression = new Ridge(1.0);

// Обучаем модель
$regression->train($dataset);
