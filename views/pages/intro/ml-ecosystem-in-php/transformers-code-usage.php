<?php

use function Codewithkyrian\Transformers\Pipelines\pipeline;

// Allocate a pipeline for sentiment analysis
$classifier = pipeline('sentiment-analysis');

$out = $classifier(['I love transformers!']);
echo print_r($out, true) . PHP_EOL;

$out = $classifier(['I hate transformers!']);
echo print_r($out, true);
