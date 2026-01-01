<?php

class LinearModel {
    public float $w;
    public float $b;

    public function __construct(float $w, float $b) {
        $this->w = $w;
        $this->b = $b;
    }

    public function predict(float $x): float {
        return $this->w * $x + $this->b;
    }
}
