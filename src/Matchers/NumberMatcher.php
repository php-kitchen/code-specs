<?php
namespace DeKey\Tester\Matchers;

use PHPUnit_Framework_Assert as Assert;

/**
 * NumberMatcher is designed to check given number matches expectation.
 *
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class NumberMatcher extends ValueMatcher {
    public function isFinite() {
        Assert::assertFinite($this->actual, $this->description);
        return $this;
    }

    public function isInfinite() {
        Assert::assertInfinite($this->actual, $this->description);
        return $this;
    }

    public function isNan() {
        Assert::assertNan($this->actual, $this->description);
        return $this;
    }
}