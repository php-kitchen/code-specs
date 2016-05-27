<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\ArrayMatcher;

/**
 * Unit test for {@link ArrayMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\ArrayMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class ArrayMatcherTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new ArrayMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . ArrayMatcher::class);
        }
    }

    /**
     * @covers ::hasKey
     */
    public function testHasKey() {
        $matcher = $this->createMatcherWithActualValue([1 => 1, 'two' => 2]);
        $matcher->hasKey(1);
        $matcher->hasKey('two');
    }

    /**
     * @covers ::doesNotHaveKey
     */
    public function testDoesNotHaveKey() {
        $matcher = $this->createMatcherWithActualValue([1 => 1, 'two' => 2]);
        $matcher->doesNotHaveKey(0);
        $matcher->doesNotHaveKey('three');
    }

    /**
     * @covers ::contains
     */
    public function testContains() {
        $matcher = $this->createMatcherWithActualValue([0, 1, $this]);
        $matcher->contains(static::class);
        $matcher->contains($this);
        $matcher->contains(0);
    }

    /**
     * @covers ::doesNotContain
     */
    public function testDoesNotContain() {
        $matcher = $this->createMatcherWithActualValue([0, 1]);
        $matcher->doesNotContain(123);
    }

    /**
     * @covers ::containsOnlyValuesOfType
     */
    public function testContainsOnlyValuesOfType() {
        $matcher = $this->createMatcherWithActualValue([$this, $this]);
        $matcher->containsOnlyValuesOfType(static::class);
    }

    /**
     * @covers ::containsOnlyValuesOfNativeType
     */
    public function testContainsOnlyValuesOfNativeType() {
        $matcher = $this->createMatcherWithActualValue([true, false]);
        $matcher->containsOnlyValuesOfNativeType('boolean');
    }

    /**
     * @covers ::containsOnlyInstancesOf
     */
    public function testContainsOnlyInstancesOf() {
        $matcher = $this->createMatcherWithActualValue([$this, $this]);
        $matcher->containsOnlyInstancesOf(static::class);
    }

    /**
     * @covers ::doesNotContainOnlyValuesOfType
     */
    public function testDoesNotContainOnlyValuesOfType() {
        $matcher = $this->createMatcherWithActualValue([$this, $this]);
        $matcher->doesNotContainOnlyValuesOfType(\Exception::class);
    }

    /**
     * @covers ::doesNotContainOnlyValuesOfNativeType
     */
    public function testDoesNotContainOnlyValuesOfNativeType() {
        $matcher = $this->createMatcherWithActualValue([1, 0]);
        $matcher->doesNotContainOnlyValuesOfNativeType('boolean');
    }

    /**
     * @covers ::isEqualToCountOf
     */
    public function testIsEqualToCountOf() {
        $matcher = $this->createMatcherWithActualValue([1, 0]);
        $matcher->isEqualToCountOf(2);
    }

    /**
     * @covers ::isNotEqualToCountOf
     */
    public function testIsNotEqualToCountOf() {
        $matcher = $this->createMatcherWithActualValue([2, 1, 0]);
        $matcher->isNotEqualToCountOf(2);
    }

    protected function createMatcherWithActualValue($value) {
        return new ArrayMatcher($value, 'matcher does not work');
    }
}