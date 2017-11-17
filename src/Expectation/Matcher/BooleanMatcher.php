<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * BooleanMatcher is designed to check given boolean variable matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class BooleanMatcher extends ValueMatcher {
    /**
     * @return $this
     */
    public function isTrue() {
        $this->startStep('is true')
            ->assertTrue();
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotTrue() {
        $this->startStep('is not true')
            ->assertNotTrue();
        return $this;
    }

    /**
     * @return $this
     */
    public function isFalse() {
        $this->startStep('is false')
            ->assertFalse();
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotFalse() {
        $this->startStep('is not false')
            ->assertNotFalse();
        return $this;
    }
}