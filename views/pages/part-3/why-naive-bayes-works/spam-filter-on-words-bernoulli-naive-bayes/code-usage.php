<?php

include __DIR__ . '/code.php';

// Input email represented as a set of words (tokens).
$input = ['free', 'meeting'];

// We will compute a log-score for each class.
$scores = [];

foreach ($classes as $class => $count) {
    // Start with the log prior probability log P(class).
    $logProb = log($count / $totalDocs);

    foreach ($vocabulary as $word) {
        $wordCount = $wordCounts[$class][$word] ?? 0;

        // Bernoulli Naive Bayes with Laplace smoothing:
        // P(word=1 | class) = (n + 1) / (N + 2)
        // where:
        // n = number of documents of this class that contain the word
        // N = total number of documents in this class
        $prob = ($wordCount + 1) / ($count + 2);

        if (in_array($word, $input, true)) {
            // Word is present in the input email.
            $logProb += log($prob);
        } else {
            // Word is absent in the input email (important for Bernoulli!).
            $logProb += log(1 - $prob);
        }
    }

    $scores[$class] = $logProb;
}

// Sort classes by score (highest / closest to 0 is the prediction).
arsort($scores);
print_r($scores);
