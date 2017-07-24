<?php

namespace DeKey\Tester\Matchers;

/**
 * NumberMatcher is designed to check given number matches expectation.
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class NumberMatcher extends ValueMatcher {
    public function isFinite(): self {
        $this->registerExpectation('is finite');
        $this->test->assertFinite($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isInfinite(): self {
        $this->registerExpectation('is infinite');
        $this->test->assertInfinite($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNan(): self {
        $this->registerExpectation('is nan');
        $this->test->assertNan($this->actual, $this->getMessageForAssert());
        return $this;
    }
}