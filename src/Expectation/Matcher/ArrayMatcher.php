<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * ArrayMatcher is designed to check given array matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ArrayMatcher extends ValueMatcher {
    /**
     * @return $this
     */
    public function hasKey($key) {
        $this->startStep('has key "' . $key . '"')
             ->assertArrayHasKey($key);

        return $this;
    }

    /**
     * @return $this
     */
    /**
     * @return $this
     */
    public function doesNotHaveKey($key) {
        $this->startStep('does not have key "' . $key . '"')
             ->assertArrayNotHasKey($key);

        return $this;
    }

    /**
     * @return $this
     */
    public function hasSubset($subset, $subsetName = '') {
        $stepName = $subsetName ? "has subset \"{$subsetName}\"" : 'has expected subset';
        $this->startStep($stepName)
             ->assertArraySubset($subset, false);

        return $this;
    }

    /**
     * In addition of verification that the array has subset check for object identity in subset and actual array.
     *
     * @param array|\ArrayAccess $subset
     *
     * @return $this
     */
    /**
     * @return $this
     */
    public function hasExactlyTheSameSubset($subset, $subsetName = '') {
        $stepName = $subsetName ? "has exactly the same subset \"{$subsetName}\"" : 'has exactly the same expected subset';

        $this->startStep($stepName)
             ->assertArraySubset($subset, true);

        return $this;
    }

    /**
     * @return $this
     */
    public function hasSameSizeAs($expected, $expectedValueName = '') {
        $stepName = $expectedValueName ? "has same size as {$expectedValueName}" : "has same size as expected";

        $this->startStep($stepName)
             ->assertSameSize($expected);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotHaveSameSizeAs($expected, $expectedValueName = '') {
        $stepName = $expectedValueName ? "does not have same size as {$expectedValueName}" : "does not have same size as expected";

        $this->startStep($stepName)
             ->assertNotSameSize($expected);

        return $this;
    }

    /**
     * @return $this
     */
    public function contains($needle, $needleName = '') {
        $stepName = $needleName ? "contains {$needleName}" : "contains expected needle";

        $this->startStep($stepName)
             ->assertContains($needle);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotContain($needle, $needleName = '') {
        $stepName = $needleName ? "does not contain {$needleName}" : "does not contain expected needle";

        $this->startStep($stepName)
             ->assertNotContains($needle);

        return $this;
    }

    /**
     * @return $this
     */
    public function containsOnlyValuesOfType($type) {
        $this->startStep('contains only values of type "' . $type . '"')
             ->assertContainsOnly($type);

        return $this;
    }

    /**
     * @return $this
     */
    public function containsOnlyValuesOfNativeType($type) {
        $this->startStep('contains only values of native type "' . $type . '"')
             ->assertContainsOnly($type, true);

        return $this;
    }

    /**
     * @return $this
     */
    public function containsOnlyInstancesOf($class) {
        $this->startStep('contains only instances of "' . $class . '"')
             ->assertContainsOnlyInstancesOf($class);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotContainOnlyValuesOfType($type) {
        $this->startStep('does not contain only values of type "' . $type . '"')
             ->assertNotContainsOnly($type, null);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotContainOnlyValuesOfNativeType($type) {
        $this->startStep('does not contain only values of native type "' . $type . '"')
             ->assertNotContainsOnly($type, true);

        return $this;
    }

    /**
     * @return $this
     */
    public function countIsEqualToCountOf($countOrCountable, $expectedValueName = '') {
        $stepName = $expectedValueName ? "has count equal to count of {$expectedValueName}" : "has count equal to count of expected";

        $this->startStep($stepName)
             ->assertCount($this->convertToCount($countOrCountable));

        return $this;
    }

    /**
     * @return $this
     */
    public function countIsNotEqualToCountOf($countOrCountable, $expectedValueName = '') {
        $stepName = $expectedValueName ? "does not have count equal count of {$expectedValueName}" : "does not have count equal count of expected";

        $this->startStep($stepName)
             ->assertNotCount($this->convertToCount($countOrCountable));

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