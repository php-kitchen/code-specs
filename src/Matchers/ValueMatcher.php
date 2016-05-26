<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Base\Matcher;
use PHPUnit_Framework_Assert as Assert;

/**
 * ValueMatcher is designed to check given value matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko
 */
class ValueMatcher extends Matcher {
    public function isInternalType($type) {
        Assert::assertInternalType($type, $this->actual, $this->description);
        return $this;
    }

    public function isNotInternalType($type) {
        Assert::assertNotInternalType($type, $this->actual, $this->description);
        return $this;
    }

    public function isEqualTo($expected) {
        Assert::assertEquals($expected, $this->actual, $this->description);
        return $this;
    }

    public function isNotEqualTo($expected) {
        Assert::assertNotEquals($expected, $this->actual, $this->description);
        return $this;
    }

    public function isGreaterThan($expected) {
        Assert::assertGreaterThan($expected, $this->actual, $this->description);
        return $this;
    }

    public function isLessThan($expected) {
        Assert::assertLessThan($expected, $this->actual, $this->description);
        return $this;
    }

    public function isGreaterOrEqualTo($expected) {
        Assert::assertGreaterThanOrEqual($expected, $this->actual, $this->description);
        return $this;
    }

    public function isLessOrEqualTo($expected) {
        Assert::assertLessThanOrEqual($expected, $this->actual, $this->description);
        return $this;
    }

    public function isNull() {
        Assert::assertNull($this->actual, $this->description);
        return $this;
    }

    public function isNotNull() {
        Assert::assertNotNull($this->actual, $this->description);
        return $this;
    }

    public function isEmpty() {
        Assert::assertEmpty($this->actual, $this->description);
        return $this;
    }

    public function isNotEmpty() {
        Assert::assertNotEmpty($this->actual, $this->description);
        return $this;
    }

    public function isTheSameAs($expected) {
        Assert::assertSame($expected, $this->actual, $this->description);
        return $this;
    }

    public function isNotTheSameAs($expected) {
        Assert::assertNotSame($expected, $this->actual, $this->description);
        return $this;
    }
}