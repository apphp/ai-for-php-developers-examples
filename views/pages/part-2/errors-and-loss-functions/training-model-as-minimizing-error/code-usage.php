<?php

require_once __DIR__ . '/code.php';

$x = [1, 2, 3, 4];
$y = [2, 4, 6, 8];

$result = findBestW($x, $y);
$bestW = $result['bestW'];
$bestLoss = num_format($result['bestLoss']);

$bestWFormatted = $bestW !== null ? num_format($bestW, 2, '.', '') : 'null';

echo "Best w ≈ {$bestWFormatted}, loss ≈ {$bestLoss}\n";
echo "Predict for 5: ≈ " . (5 * $bestW);
