<?php

/**
 * A minimal 1D linear regression model.
 *
 * The model represents a straight line:
 *  ŷ = w * x + b
 */
class LinearModel {
    /**
     * Slope (weight) of the linear function.
     */
    public float $w;

    /**
     * Intercept (bias) of the linear function.
     */
    public float $b;

    /**
     * @param float $w Slope (weight)
     * @param float $b Intercept (bias)
     */
    public function __construct(float $w, float $b) {
        $this->w = $w;
        $this->b = $b;
    }

    /**
     * Predict the target value for a single input.
     *
     * @param float $x Input feature value
     * @return float Predicted value ŷ
     */
    public function predict(float $x): float {
        return $this->w * $x + $this->b;
    }
}

/**
 * Squared error loss for a single sample.
 *
 * SE = (ŷ - y)^2
 *
 * @param float $yTrue Ground-truth value y
 * @param float $yPredicted Model prediction ŷ
 * @return float Non-negative loss value
 */
function squaredError(float $yTrue, float $yPredicted): float {
    return ($yPredicted - $yTrue) ** 2;
}
