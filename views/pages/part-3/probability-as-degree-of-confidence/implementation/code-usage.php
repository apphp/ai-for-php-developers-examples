<?php

require_once __DIR__ . '/code.php';

// Example raw scores ("logits") for each email category before converting to probabilities
$scores = [
    'spam'   => 2.1,
    'promo'  => 1.3,
    'normal' => 0.2,
];

$probabilities = softmax($scores);

foreach ($probabilities as $class => $probability) {
    echo $class . ': ' . round($probability, 3) . PHP_EOL;
}
