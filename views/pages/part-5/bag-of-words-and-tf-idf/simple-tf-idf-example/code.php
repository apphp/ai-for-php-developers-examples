<?php

// --------------------
// Tokenization
// --------------------
function tokenize(string $text): array {
    return explode(' ', $text);
}

$tokenized = array_map('tokenize', $documents);

// --------------------
// Build vocabulary
// --------------------
$vocab = [];
foreach ($tokenized as $doc) {
    foreach ($doc as $word) {
        $vocab[$word] = true;
    }
}
$vocab = array_keys($vocab);

// --------------------
// Term Frequency (TF)
// --------------------
function termFrequency(array $doc): array {
    $tf = [];
    $length = count($doc);

    foreach ($doc as $word) {
        $tf[$word] = ($tf[$word] ?? 0) + 1;
    }

    foreach ($tf as $word => $count) {
        $tf[$word] = $count / $length;
    }

    return $tf;
}

// --------------------
// Document Frequency + IDF
// --------------------
function documentFrequency(array $tokenized): array {
    $df = [];

    foreach ($tokenized as $doc) {
        foreach (array_unique($doc) as $word) {
            $df[$word] = ($df[$word] ?? 0) + 1;
        }
    }

    return $df;
}

$df = documentFrequency($tokenized);
$N  = count($tokenized);

$idf = [];
foreach ($df as $word => $count) {
    $idf[$word] = log($N / $count);
}

// --------------------
// TF–IDF
// --------------------
function tfidf(array $tf, array $idf): array {
    $vector = [];

    foreach ($tf as $word => $value) {
        $vector[$word] = $value * ($idf[$word] ?? 0);
    }

    return $vector;
}

$tfidfVectors = [];
foreach ($tokenized as $doc) {
    $tf = termFrequency($doc);
    $tfidfVectors[] = tfidf($tf, $idf);
}
