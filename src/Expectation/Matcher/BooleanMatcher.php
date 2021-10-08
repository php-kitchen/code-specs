<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * BooleanMatcher is designed to check given boolean variable matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class BooleanMatcher extends ValueMatcher {
    public function isTrue(): self {
        $this->startStep('is true')
             ->assertTrue();

        return $this;
    }

    public function isNotTrue(): self {
        $this->startStep('is not true')
             ->assertNotTrue();

        return $this;
    }

    public function isFalse(): self {
        $this->startStep('is false')
             ->assertFalse();

        return $this;
    }

    public function isNotFalse(): self {
        $this->startStep('is not false')
             ->assertNotFalse();

        return $this;
    }
}
