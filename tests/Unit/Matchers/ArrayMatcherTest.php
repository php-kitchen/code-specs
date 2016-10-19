<?php
namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Matchers\ArrayMatcher;
use Tests\DeKey\Tester\Base\BaseMatcherTest;

/**
 * Unit test for {@link ArrayMatcher}
 *
 * @method ArrayMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\ArrayMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class ArrayMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = ArrayMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createMatcherWithActualValue([]);
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . ArrayMatcher::class);
        }
    }

    /**
     * @covers ::hasKey
     */
    public function testHasKey() {
        $array = $this->createMatcherWithActualValue([1 => 1, 'two' => 2]);
        $array->hasKey(1);
        $array->hasKey('two');
    }

    /**
     * @covers ::doesNotHaveKey
     */
    public function testDoesNotHaveKey() {
        $array = $this->createMatcherWithActualValue([1 => 1, 'two' => 2]);
        $array->doesNotHaveKey(0);
        $array->doesNotHaveKey('three');
    }

    /**
     * @covers ::contains
     */
    public function testContains() {
        $array = $this->createMatcherWithActualValue([0, 1, $this]);
        $array->contains(static::class);
        $array->contains($this);
        $array->contains(0);
    }

    /**
     * @covers ::doesNotContain
     */
    public function testDoesNotContain() {
        $array = $this->createMatcherWithActualValue([0, 1]);
        $array->doesNotContain(123);
    }

    /**
     * @covers ::containsOnlyValuesOfType
     */
    public function testContainsOnlyValuesOfType() {
        $array = $this->createMatcherWithActualValue([$this, $this]);
        $array->containsOnlyValuesOfType(static::class);
    }

    /**
     * @covers ::containsOnlyValuesOfNativeType
     */
    public function testContainsOnlyValuesOfNativeType() {
        $array = $this->createMatcherWithActualValue([true, false]);
        $array->containsOnlyValuesOfNativeType('boolean');
    }

    /**
     * @covers ::containsOnlyInstancesOf
     */
    public function testContainsOnlyInstancesOf() {
        $array = $this->createMatcherWithActualValue([$this, $this]);
        $array->containsOnlyInstancesOf(static::class);
    }

    /**
     * @covers ::doesNotContainOnlyValuesOfType
     */
    public function testDoesNotContainOnlyValuesOfType() {
        $array = $this->createMatcherWithActualValue([$this, $this]);
        $array->doesNotContainOnlyValuesOfType(\Exception::class);
    }

    /**
     * @covers ::doesNotContainOnlyValuesOfNativeType
     */
    public function testDoesNotContainOnlyValuesOfNativeType() {
        $array = $this->createMatcherWithActualValue([1, 0]);
        $array->doesNotContainOnlyValuesOfNativeType('boolean');
    }

    /**
     * @covers ::countIsEqualToCountOf
     * @covers ::convertToCount
     */
    public function testCountIsEqualToCountOf() {
        $array = $this->createMatcherWithActualValue([1, 0]);
        $array->countIsEqualToCountOf(2);
        $array->countIsEqualToCountOf([1, 2]);
    }

    /**
     * @covers ::countIsNotEqualToCountOf
     * @covers ::convertToCount
     */
    public function testIsNotEqualToCountOf() {
        $array = $this->createMatcherWithActualValue([2, 1, 0]);
        $array->countIsNotEqualToCountOf(2);
        $array->countIsNotEqualToCountOf([1, 2]);
    }

    /**
     * @covers ::hasSubset
     */
    public function testHasSubset() {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->hasSubset([2, 1]);
    }

    /**
     * @covers ::hasExactlyTheSameSubset
     */
    public function testHasExactlyTheSameSubset() {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->hasExactlyTheSameSubset([2, '1']);
    }

    /**
     * @covers ::hasSameSizeAs
     */
    public function testHasSameSizeAs() {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->hasSameSizeAs([1, 2, 3]);
    }

    /**
     * @covers ::doesNotHaveSameSizeAs
     */
    public function testDoesNotHaveSameSizeAs() {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->doesNotHaveSameSizeAs([1, 2, 3, 4]);
    }
}