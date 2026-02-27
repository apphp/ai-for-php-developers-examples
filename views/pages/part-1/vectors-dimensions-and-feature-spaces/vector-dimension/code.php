<?php

function predict(array $features): float {
    if (count($features) !== 10) {
        throw new InvalidArgumentException('Expecting a vector of dimension 10');
    }

    // Further calculations
    return 0.75;
}
