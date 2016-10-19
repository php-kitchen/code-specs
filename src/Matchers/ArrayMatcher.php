<?php

namespace DeKey\Tester\Matchers;

use PHPUnit_Framework_Assert as Assert;

/**
 * ArrayMatcher is designed to check given array matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class ArrayMatcher extends ValueMatcher {
    public function hasKey($key) {
        Assert::assertArrayHasKey($key, $this->actual, $this->description);
        return $this;
    }

    public function doesNotHaveKey($key) {
        Assert::assertArrayNotHasKey($key, $this->actual, $this->description);
        return $this;
    }

    public function hasSubset($subset) {
        Assert::assertArraySubset($subset, $this->actual, false, $this->description);
        return $this;
    }

    /**
     * In addition of verification that the array has subset check for object identity in subset and actual array.
     *
     * @param array|\ArrayAccess $subset
     * @return $this
     */
    public function hasExactlyTheSameSubset($subset) {
        Assert::assertArraySubset($subset, $this->actual, true, $this->description);
        return $this;
    }

    public function hasSameSizeAs($expected) {
        Assert::assertSameSize($expected, $this->actual, $this->description);
        return $this;
    }

    public function doesNotHaveSameSizeAs($expected) {
        Assert::assertNotSameSize($expected, $this->actual, $this->description);
        return $this;
    }

    public function contains($needle) {
        Assert::assertContains($needle, $this->actual, $this->description);
        return $this;
    }

    public function doesNotContain($needle) {
        Assert::assertNotContains($needle, $this->actual, $this->description);
        return $this;
    }

    public function containsOnlyValuesOfType($type) {
        Assert::assertContainsOnly($type, $this->actual, null, $this->description);
        return $this;
    }

    public function containsOnlyValuesOfNativeType($type) {
        Assert::assertContainsOnly($type, $this->actual, true, $this->description);
        return $this;
    }

    public function containsOnlyInstancesOf($class) {
        Assert::assertContainsOnlyInstancesOf($class, $this->actual, $this->description);
        return $this;
    }

    public function doesNotContainOnlyValuesOfType($type) {
        Assert::assertNotContainsOnly($type, $this->actual, null, $this->description);
        return $this;
    }

    public function doesNotContainOnlyValuesOfNativeType($type) {
        Assert::assertNotContainsOnly($type, $this->actual, true, $this->description);
        return $this;
    }

    public function countIsEqualToCountOf($countOrCountable) {
        Assert::assertCount($this->convertToCount($countOrCountable), $this->actual, $this->description);
        return $this;
    }

    public function countIsNotEqualToCountOf($countOrCountable) {
        Assert::assertNotCount($this->convertToCount($countOrCountable), $this->actual, $this->description);
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