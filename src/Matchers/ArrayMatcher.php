<?php

namespace DeKey\Tester\Matchers;

/**
 * ArrayMatcher is designed to check given array matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ArrayMatcher extends ValueMatcher {
    public function hasKey($key) {
        $this->registerExpectation('has key "' . $key . '"');
        $this->test->assertArrayHasKey($key, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotHaveKey($key) {
        $this->registerExpectation('does not have key "' . $key . '"');
        $this->test->assertArrayNotHasKey($key, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function hasSubset($subset) {
        $this->registerExpectation('has subset "' . print_r($subset, true) . '"');
        $this->test->assertArraySubset($subset, $this->actual, false, $this->getMessageForAssert());
        return $this;
    }

    /**
     * In addition of verification that the array has subset check for object identity in subset and actual array.
     *
     * @param array|\ArrayAccess $subset
     * @return $this
     */
    public function hasExactlyTheSameSubset($subset) {
        $this->registerExpectation('has exactly the same subset "' . print_r($subset, true) . '"');
        $this->test->assertArraySubset($subset, $this->actual, true, $this->getMessageForAssert());
        return $this;
    }

    public function hasSameSizeAs($expected) {
        $this->registerExpectation('has same size as expected');
        $this->test->assertSameSize($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotHaveSameSizeAs($expected) {
        $this->registerExpectation('does not have same size as expected');
        $this->test->assertNotSameSize($expected, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function contains($needle) {
        $this->test->assertContains($needle, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotContain($needle) {
        $this->registerExpectation('contains "' . print_r($needle, true) . '"');
        $this->test->assertNotContains($needle, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function containsOnlyValuesOfType($type) {
        $this->registerExpectation('contains only values of type "' . $type . '"');
        $this->test->assertContainsOnly($type, $this->actual, null, $this->getMessageForAssert());
        return $this;
    }

    public function containsOnlyValuesOfNativeType($type) {
        $this->registerExpectation('contains only values of native type "' . $type . '"');
        $this->test->assertContainsOnly($type, $this->actual, true, $this->getMessageForAssert());
        return $this;
    }

    public function containsOnlyInstancesOf($class) {
        $this->registerExpectation('contains only instances of "' . $class . '"');
        $this->test->assertContainsOnlyInstancesOf($class, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotContainOnlyValuesOfType($type) {
        $this->registerExpectation('does not contain only values of type "' . $type . '"');
        $this->test->assertNotContainsOnly($type, $this->actual, null, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotContainOnlyValuesOfNativeType($type) {
        $this->registerExpectation('does not contain only values of native type "' . $type . '"');
        $this->test->assertNotContainsOnly($type, $this->actual, true, $this->getMessageForAssert());
        return $this;
    }

    public function countIsEqualToCountOf($countOrCountable) {
        $this->registerExpectation('has count equal to expected');
        $this->test->assertCount($this->convertToCount($countOrCountable), $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function countIsNotEqualToCountOf($countOrCountable) {
        $this->registerExpectation('has count not equal to expected');
        $this->test->assertNotCount($this->convertToCount($countOrCountable), $this->actual, $this->getMessageForAssert());
        return $this;
    }

    protected function convertToCount($value) {
        if (is_array($value) || $value instanceof \Countable || $value instanceof \Traversable) {
            $count = count($value);
        } else {
            $count = $value;
        }
        return $count;
    }
}