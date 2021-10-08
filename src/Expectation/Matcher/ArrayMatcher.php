<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * ArrayMatcher is designed to check given array matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ArrayMatcher extends ValueMatcher {
    public function hasKey($key): self {
        $this->startStep('has key "' . $key . '"')
             ->assertArrayHasKey($key);

        return $this;
    }

    public function doesNotHaveKey($key): self {
        $this->startStep('does not have key "' . $key . '"')
             ->assertArrayNotHasKey($key);

        return $this;
    }

    public function hasSubset($subset, $subsetName = ''): self {
        $stepName = $subsetName ? "has subset \"{$subsetName}\"" : 'has expected subset';
        $this->startStep($stepName)
             ->assertArraySubset($subset, false);

        return $this;
    }

    public function hasExactlyTheSameSubset($subset, $subsetName = ''): self {
        $stepName = $subsetName ? "has exactly the same subset \"{$subsetName}\"" : 'has exactly the same expected subset';

        $this->startStep($stepName)
             ->assertArraySubset($subset, true);

        return $this;
    }

    public function hasSameSizeAs($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "has same size as {$expectedValueName}" : "has same size as expected";

        $this->startStep($stepName)
             ->assertSameSize($expected);

        return $this;
    }

    public function doesNotHaveSameSizeAs($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "does not have same size as {$expectedValueName}" : "does not have same size as expected";

        $this->startStep($stepName)
             ->assertNotSameSize($expected);

        return $this;
    }

    public function contains($needle, $needleName = ''): self {
        $stepName = $needleName ? "contains {$needleName}" : "contains expected needle";

        $this->startStep($stepName)
             ->assertContains($needle);

        return $this;
    }

    public function doesNotContain($needle, $needleName = ''): self {
        $stepName = $needleName ? "does not contain {$needleName}" : "does not contain expected needle";

        $this->startStep($stepName)
             ->assertNotContains($needle);

        return $this;
    }

    public function containsEqual($needle, $needleName = ''): self {
        $stepName = $needleName ? "contains {$needleName}" : "contains expected needle";

        $this->startStep($stepName)
             ->assertContainsEquals($needle);

        return $this;
    }

    public function doesNotContainsEqual($needle, $needleName = ''): self {
        $stepName = $needleName ? "does not contain {$needleName}" : "does not contain expected needle";

        $this->startStep($stepName)
             ->assertNotContainsEquals($needle);

        return $this;
    }

    public function containsOnlyValuesOfType(string $type): self {
        $this->startStep('contains only values of type "' . $type . '"')
             ->assertContainsOnly($type);

        return $this;
    }

    public function containsOnlyValuesOfNativeType(string $type): self {
        $this->startStep('contains only values of native type "' . $type . '"')
             ->assertContainsOnly($type, true);

        return $this;
    }

    public function containsOnlyInstancesOf(string $class): self {
        $this->startStep('contains only instances of "' . $class . '"')
             ->assertContainsOnlyInstancesOf($class);

        return $this;
    }

    public function doesNotContainOnlyValuesOfType(string $type): self {
        $this->startStep('does not contain only values of type "' . $type . '"')
             ->assertNotContainsOnly($type, null);

        return $this;
    }

    public function doesNotContainOnlyValuesOfNativeType(string $type): self {
        $this->startStep('does not contain only values of native type "' . $type . '"')
             ->assertNotContainsOnly($type, true);

        return $this;
    }

    public function countIsEqualToCountOf($countOrCountable, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "has count equal to count of {$expectedValueName}" : "has count equal to count of expected";

        $this->startStep($stepName)
             ->assertCount($this->convertToCount($countOrCountable));

        return $this;
    }

    public function countIsNotEqualToCountOf($countOrCountable, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "does not have count equal count of {$expectedValueName}" : "does not have count equal count of expected";

        $this->startStep($stepName)
             ->assertNotCount($this->convertToCount($countOrCountable));

        return $this;
    }

    protected function convertToCount($value): int {
        if (is_iterable($value)) {
            $count = count($value);
        } else {
            $count = $value;
        }

        return $count;
    }
}
