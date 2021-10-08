<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * NumberMatcher is designed to check given number matches expectation.
 *
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class NumberMatcher extends ValueMatcher {
    public function isFinite(): self {
        $this->startStep('is finite')
             ->assertFinite();

        return $this;
    }

    public function isInfinite(): self {
        $this->startStep('is infinite')
             ->assertInfinite();

        return $this;
    }

    public function isNan(): self {
        $this->startStep('is nan')
             ->assertNan();

        return $this;
    }
}
