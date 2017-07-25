<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Matchers\Base\Matcher;

/**
 * ValueMatcher is designed to check given value matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ValueMatcher extends Matcher {
    public function isInternalType($type) {
        $this->registerExpectation('is internal type "' . $type . '"');
        $this->test->assertInternalType($type, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotInternalType($type) {
        $this->registerExpectation('is not internal type "' . $type . '"');
        $this->test->assertNotInternalType($type, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualTo($expected) {
        $expectedString = $this->serializePotentiallyBigVariable($expected);
        $this->registerExpectation('is equal to "' . $expectedString . '"');
        $this->test->assertEquals($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualTo($expected) {
        $expectedString = $this->serializePotentiallyBigVariable($expected);
        $this->registerExpectation('is not equal to "' . $expectedString . '"');
        $this->test->assertNotEquals($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isGreaterThan($expected) {
        $this->registerExpectation('is greater than "' . $expected . '"');
        $this->test->assertGreaterThan($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isLessThan($expected) {
        $this->registerExpectation('is less than "' . $expected . '"');
        $this->test->assertLessThan($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isGreaterOrEqualTo($expected) {
        $this->registerExpectation('is greater or equal to "' . $expected . '"');
        $this->test->assertGreaterThanOrEqual($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isLessOrEqualTo($expected) {
        $this->registerExpectation('is less or equal to "' . $expected . '"');
        $this->test->assertLessThanOrEqual($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNull() {
        $this->registerExpectation('is null');
        $this->test->assertNull($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotNull() {
        $this->registerExpectation('is not null');
        $this->test->assertNotNull($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEmpty() {
        $this->registerExpectation('is empty');
        $this->test->assertEmpty($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEmpty() {
        $this->registerExpectation('is not empty');
        $this->test->assertNotEmpty($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isTheSameAs($expected) {
        $expectedString = $this->serializePotentiallyBigVariable($expected);
        $this->registerExpectation('is the same as "' . $expectedString . '"');
        $this->test->assertSame($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotTheSameAs($expected) {
        $expectedString = $this->serializePotentiallyBigVariable($expected);
        $this->registerExpectation('is not the same as "' . $expectedString . '"');
        $this->test->assertNotSame($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    protected function serializePotentiallyBigVariable($variable) {
        return is_object($variable) ? 'expected' : print_r($variable, true);
    }
}