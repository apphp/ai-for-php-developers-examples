<?php

use Rubix\ML\Datasets\Unlabeled;

include __DIR__ . '/rubix-code.php';

// Новый объект: from_ads = 1, has_account = 1.
$sample = [1, 1];

// Оборачиваем в Unlabeled‑датасет, как того ожидает RubixML.
$dataset = new Unlabeled([$sample]);

// Предсказываем класс.
$prediction = $model->predict($dataset);

print_r($prediction);

