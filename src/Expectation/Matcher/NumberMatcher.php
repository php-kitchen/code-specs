<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * NumberMatcher is designed to check given number matches expectation.
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class NumberMatcher extends ValueMatcher {
    /**
     * @return $this
     */
    public function isFinite(): self {
        $this->startStep('is finite')
             ->assertFinite();

        return $this;
    }

    /**
     * @return $this
     */
    public function isInfinite(): self {
        $this->startStep('is infinite')
             ->assertInfinite();

        return $this;
    }

    /**
     * @return $this
     */
    public function isNan(): self {
        $this->startStep('is nan')
             ->assertNan();

        return $this;
    }
}