<?php

// Toy dataset: each email is a list of tokens (words) + a class label.
$emails = [
    ['text' => ['free', 'win'], 'class' => 'spam'],
    ['text' => ['free'],        'class' => 'spam'],
    ['text' => ['meeting'],     'class' => 'ham'],
    ['text' => ['project'],     'class' => 'ham'],
];

// Count how many documents belong to each class (priors).
$classes = [];
$totalDocs = count($emails);

foreach ($emails as $email) {
    $class = $email['class'];
    $classes[$class] = ($classes[$class] ?? 0) + 1;
}

// For Bernoulli Naive Bayes we count, per class, in how many documents each word appears.
// (Presence/absence is what matters, not the number of repetitions inside the same document.)
$wordCounts = [];

foreach ($emails as $email) {
    $class = $email['class'];

    // Count each word only once per document.
    $uniqueWords = array_unique($email['text']);

    // In Bernoulli NB we count the fact of presence (1/0), not term frequency.
    foreach ($uniqueWords as $word) {
        $wordCounts[$class][$word] = ($wordCounts[$class][$word] ?? 0) + 1;
    }
}

// Build the global vocabulary (set of all words seen in training).
$vocabulary = [];

foreach ($wordCounts as $classWords) {
    foreach ($classWords as $word => $_) {
        $vocabulary[$word] = true;
    }
}

$vocabulary = array_keys($vocabulary);
