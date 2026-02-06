<?php

require_once __DIR__ . '/code.php';

$y = [1, 0, 1, 0];
$modelA = [0.9, 0.2, 0.9, 0.2];
$modelB = [0.6, 0.4, 0.6, 0.4];

echo "Log loss A: " . logLoss($y, $modelA) . PHP_EOL;
echo "Log loss B: " . logLoss($y, $modelB) . PHP_EOL;
