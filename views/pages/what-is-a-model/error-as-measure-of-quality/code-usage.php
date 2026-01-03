<?php

require_once __DIR__ . '/code.php';

echo 'Error: ' . error(yTrue: 10.0, yPredicted: 7.0) . PHP_EOL;

echo 'Squared Error: ' . squaredError(yTrue: 4.0, yPredicted: 6.0) . PHP_EOL;
