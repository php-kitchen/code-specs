<?php

namespace Tests\Unit\Matchers;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Exception;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ArrayMatcher;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link ArrayMatcher}
 *
 * @method ArrayMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\ArrayMatcher
 *
 * @package Tests\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ArrayMatcherTest extends BaseMatcherTest {
    use ArraySubsetAsserts;

    protected function initMatcherClass(): void {
        $this->matcherClass = ArrayMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate(): void {
        try {
            $this->createMatcherWithActualValue([]);
            $matcherCreated = true;
        } catch (Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . ArrayMatcher::class);
    }

    /**
     * @covers ::hasKey
     */
    public function testHasKey(): void {
        $array = $this->createMatcherWithActualValue([1 => 1, 'two' => 2]);
        $array->hasKey(1);
        $array->hasKey('two');
    }

    /**
     * @covers ::doesNotHaveKey
     */
    public function testDoesNotHaveKey(): void {
        $array = $this->createMatcherWithActualValue([1 => 1, 'two' => 2]);
        $array->doesNotHaveKey(0);
        $array->doesNotHaveKey('three');
    }

    /**
     * @covers ::contains
     */
    public function testContains(): void {
        $array = $this->createMatcherWithActualValue([0, 1, $this]);
        $array->contains(1);
        $array->contains($this);
        $array->contains(0);
    }

    /**
     * @covers ::doesNotContain
     */
    public function testDoesNotContain(): void {
        $array = $this->createMatcherWithActualValue([0, 1]);
        $array->doesNotContain(123);
    }

    /**
     * @covers ::containsOnlyValuesOfType
     */
    public function testContainsOnlyValuesOfType(): void {
        $array = $this->createMatcherWithActualValue([$this, $this]);
        $array->containsOnlyValuesOfType(static::class);
    }

    /**
     * @covers ::containsOnlyValuesOfNativeType
     */
    public function testContainsOnlyValuesOfNativeType(): void {
        $array = $this->createMatcherWithActualValue([true, false]);
        $array->containsOnlyValuesOfNativeType('boolean');
    }

    /**
     * @covers ::containsOnlyInstancesOf
     */
    public function testContainsOnlyInstancesOf(): void {
        $array = $this->createMatcherWithActualValue([$this, $this]);
        $array->containsOnlyInstancesOf(static::class);
    }

    /**
     * @covers ::doesNotContainOnlyValuesOfType
     */
    public function testDoesNotContainOnlyValuesOfType(): void {
        $array = $this->createMatcherWithActualValue([$this, $this]);
        $array->doesNotContainOnlyValuesOfType(Exception::class);
    }

    /**
     * @covers ::doesNotContainOnlyValuesOfNativeType
     */
    public function testDoesNotContainOnlyValuesOfNativeType(): void {
        $array = $this->createMatcherWithActualValue([1, 0]);
        $array->doesNotContainOnlyValuesOfNativeType('boolean');
    }

    /**
     * @covers ::countIsEqualToCountOf
     * @covers ::convertToCount
     */
    public function testCountIsEqualToCountOf(): void {
        $array = $this->createMatcherWithActualValue([1, 0]);
        $array->countIsEqualToCountOf(2);
        $array->countIsEqualToCountOf([1, 2]);
    }

    /**
     * @covers ::countIsNotEqualToCountOf
     * @covers ::convertToCount
     */
    public function testIsNotEqualToCountOf(): void {
        $array = $this->createMatcherWithActualValue([2, 1, 0]);
        $array->countIsNotEqualToCountOf(2);
        $array->countIsNotEqualToCountOf([1, 2]);
    }

    /**
     * @covers ::hasSubset
     */
    public function testHasSubset(): void {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->hasSubset([2, 1]);
    }

    /**
     * @covers ::hasExactlyTheSameSubset
     */
    public function testHasExactlyTheSameSubset(): void {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->hasExactlyTheSameSubset([2, '1']);
    }

    /**
     * @covers ::hasSameSizeAs
     */
    public function testHasSameSizeAs(): void {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->hasSameSizeAs([1, 2, 3]);
    }

    /**
     * @covers ::doesNotHaveSameSizeAs
     */
    public function testDoesNotHaveSameSizeAs(): void {
        $array = $this->createMatcherWithActualValue([2, '1', 0]);

        $array->doesNotHaveSameSizeAs([1, 2, 3, 4]);
    }

    /**
     * @covers ::doesNotHaveSameSizeAs
     */
    /*public function testDelayed(): void {
        $assert = new Assert($this->getCodeSpecsModule(), $this, null, 'I see that array');
        $assert->switchToDelayedExecutionStrategy();
        $matcherArray = new ArrayMatcher($assert);
        $matcherArray->doesNotHaveSameSizeAs([1, 2, 3, 4]);
        //$array->doesNotHaveSameSizeAs([1, 2, 3, 4]);
        $matcherArray([2, '1', 0])->isNotEmpty();
    }*/
}
