<?php

require_once __DIR__ . '/code.php';

$threshold = 0.7;

if ($probabilities['spam'] >= $threshold) {
    $decision = 'Move to spam';
} else {
    $decision = 'Leave in inbox';
}

foreach ($probabilities as $class => $probability) {
    echo $class . ': ' . round($probability, 2) . PHP_EOL;
}

echo 'Порог: ' . $threshold . PHP_EOL;

echo $decision . PHP_EOL;
