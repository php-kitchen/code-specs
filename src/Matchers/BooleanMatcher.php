<?php

namespace DeKey\Tester\Matchers;

/**
 * BooleanMatcher is designed to check given boolean variable matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class BooleanMatcher extends ValueMatcher {
    public function isTrue() {
        $this->registerExpectation('is true');
        $this->test->assertTrue($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotTrue() {
        $this->registerExpectation('is not true');
        $this->test->assertNotTrue($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isFalse() {
        $this->registerExpectation('is false');
        $this->test->assertFalse($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotFalse() {
        $this->registerExpectation('is not false');
        $this->test->assertNotFalse($this->actual, $this->getMessageForAssert());
        return $this;
    }
}