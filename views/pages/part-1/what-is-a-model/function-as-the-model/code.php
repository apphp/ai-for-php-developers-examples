<?php

// Simple linear model: ŷ = w * x + b
class SimpleLinearModel {
    // Slope (weight) of the linear function
    public float $w;

    // Intercept (bias) of the linear function
    public float $b;

    // Initialize model parameters w and b
    public function __construct(float $w, float $b) {
        $this->w = $w;
        $this->b = $b;
    }

    // Make a prediction for a single input value x
    public function predict(float $x): float {
        return $this->w * $x + $this->b;
    }
}
