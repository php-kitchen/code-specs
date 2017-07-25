<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Matchers\Base\Matcher;

/**
 * ClassMatcher is designed to check given class matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ClassMatcher extends Matcher {
    public function isExist() {
        $this->registerExpectation('is exist');
        $this->test->assertTrue(class_exists($this->actual), $this->getMessageForAssert());
        return $this;
    }

    public function isNotExist() {
        $this->registerExpectation('is not exist');
        $this->test->assertFalse(class_exists($this->actual), $this->getMessageForAssert());
        return $this;
    }

    public function isInterface() {
        $this->registerExpectation('is interface');
        $this->test->assertTrue(interface_exists($this->actual), $this->getMessageForAssert());
        return $this;
    }

    public function isNotInterface() {
        $this->registerExpectation('is not interface');
        $this->test->assertFalse(interface_exists($this->actual), $this->getMessageForAssert());
        return $this;
    }

    public function hasStaticAttribute($attribute) {
        $this->registerExpectation('has static attribute "' . $attribute . '"');
        $this->test->assertClassHasStaticAttribute($attribute, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotHaveStaticAttribute($attribute) {
        $this->registerExpectation('does not have static attribute "' . $attribute . '"');
        $this->test->assertClassNotHasStaticAttribute($attribute, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function hasAttribute($attribute) {
        $this->registerExpectation('has attribute "' . $attribute . '"');
        $this->test->assertClassHasAttribute($attribute, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotHaveAttribute($attribute) {
        $this->registerExpectation('does not have attribute "' . $attribute . '"');
        $this->test->assertClassNotHasAttribute($attribute, $this->actual, $this->getMessageForAssert());
        return $this;
    }
}