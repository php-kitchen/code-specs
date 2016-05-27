<?php

namespace DeKey\Tester\Matchers;

use PHPUnit_Framework_Assert as Assert;

/**
 * ArrayMatcher is designed to check given array matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
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

    public function isEqualToCountOf($array) {
        Assert::assertCount($array, $this->actual, $this->description);
        return $this;
    }

    public function isNotEqualToCountOf($array) {
        Assert::assertNotCount($array, $this->actual, $this->description);
        return $this;
    }
}