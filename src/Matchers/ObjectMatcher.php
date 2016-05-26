<?php

namespace DeKey\Tester\Matchers;

use PHPUnit_Framework_Assert as Assert;

/**
 * ObjectMatcher is designed to check given object matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko
 */
class ObjectMatcher extends ValueMatcher {
    public function isInstanceOf($class) {
        Assert::assertInstanceOf($class, $this->actual, $this->description);
        return $this;
    }

    public function isNotInstanceOf($class) {
        Assert::assertNotInstanceOf($class, $this->actual, $this->description);
        return $this;
    }

    public function hasAttribute($attribute) {
        Assert::assertObjectHasAttribute($attribute, $this->actual, $this->description);
        return $this;
    }

    public function doesNotHaveAttribute($attribute) {
        Assert::assertObjectNotHasAttribute($attribute, $this->actual, $this->description);
        return $this;
    }
}