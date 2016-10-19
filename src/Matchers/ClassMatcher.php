<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Base\Matcher;
use PHPUnit_Framework_Assert as Assert;

/**
 * ClassMatcher is designed to check given class matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class ClassMatcher extends Matcher {
    public function isExist() {
        Assert::assertTrue(class_exists($this->actual), $this->description);
        return $this;
    }

    public function isNotExist() {
        Assert::assertFalse(class_exists($this->actual), $this->description);
        return $this;
    }

    public function isInterface() {
        Assert::assertTrue(interface_exists($this->actual), $this->description);
        return $this;
    }

    public function isNotInterface() {
        Assert::assertFalse(interface_exists($this->actual), $this->description);
        return $this;
    }

    public function hasStaticAttribute($attribute) {
        Assert::assertClassHasStaticAttribute($attribute, $this->actual, $this->description);
        return $this;
    }

    public function doesNotHaveStaticAttribute($attribute) {
        Assert::assertClassNotHasStaticAttribute($attribute, $this->actual, $this->description);
        return $this;
    }

    public function hasAttribute($attribute) {
        Assert::assertClassHasAttribute($attribute, $this->actual, $this->description);
        return $this;
    }

    public function doesNotHaveAttribute($attribute) {
        Assert::assertClassNotHasAttribute($attribute, $this->actual, $this->description);
        return $this;
    }
}