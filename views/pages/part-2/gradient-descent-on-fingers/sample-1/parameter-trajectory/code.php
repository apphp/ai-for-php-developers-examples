<?php

$x = [1, 2, 3, 4];
$y = [2, 4, 6, 8];

$w = 0.0;
$learningRate = 0.1;
$n = count($x);

echo "epoch\tw\tgradient\tloss\n";

for ($epoch = 1; $epoch <= 20; $epoch++) {
    $gradient = 0.0;
    $loss = 0.0;

    for ($i = 0; $i < $n; $i++) {
        $pred = $w * $x[$i];
        $error = $pred - $y[$i];

        $loss += $error ** 2;
        $gradient += $x[$i] * $error;
    }

    $loss /= $n;
    $gradient = (2 / $n) * $gradient;

    echo $epoch . "\t" .
        round($w, 4) . "\t" .
        round($gradient, 4) . "\t\t" .
        round($loss, 4) . PHP_EOL;

    $w -= $learningRate * $gradient;
}
