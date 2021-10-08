<?php

namespace Tests\Unit\Matchers;

use Exception;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ValueMatcher;
use stdClass;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link ValueMatcher}
 *
 * @method ValueMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\ValueMatcher
 *
 * @package Tests\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ValueMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass(): void {
        $this->matcherClass = ValueMatcher::class;
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
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . ValueMatcher::class);
    }

    /**
     * @covers ::isArray
     */
    public function testIsArray(): void {
        $matcher = $this->createMatcherWithActualValue([true]);
        $matcher->isArray();
    }

    /**
     * @covers ::isBool
     */
    public function testIsBool(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isBool();
    }

    /**
     * @covers ::isFloat
     */
    public function testIsFloat(): void {
        $matcher = $this->createMatcherWithActualValue(2.2);
        $matcher->isFloat();
    }

    /**
     * @covers ::isInt
     */
    public function testIsInt(): void {
        $matcher = $this->createMatcherWithActualValue(-45);
        $matcher->isInt();
    }

    /**
     * @covers ::isNumeric
     */
    public function testIsNumeric(): void {
        $matcher = $this->createMatcherWithActualValue(45);
        $matcher->isNumeric();
    }

    /**
     * @covers ::isObject
     */
    public function testIsObject(): void {
        $matcher = $this->createMatcherWithActualValue(new stdClass());
        $matcher->isObject();
    }

    /**
     * @covers ::isResource
     */
    public function testIsResource(): void {
        $matcher = $this->createMatcherWithActualValue(fopen(__FILE__, 'r'));
        $matcher->isResource();
    }

    /**
     * @covers ::isString
     */
    public function testIsString(): void {
        $matcher = $this->createMatcherWithActualValue('');
        $matcher->isString();
    }

    /**
     * @covers ::isScalar
     */
    public function testIsScalar(): void {
        $matcher = $this->createMatcherWithActualValue(5);
        $matcher->isScalar();
    }

    /**
     * @covers ::isCallable
     */
    public function testIsCallable(): void {
        $matcher = $this->createMatcherWithActualValue(function () {
            return true;
        });
        $matcher->isCallable();
    }

    /**
     * @covers ::isIterable
     */
    public function testIsIterable(): void {
        $matcher = $this->createMatcherWithActualValue([]);
        $matcher->isIterable();
    }

    /**
     * @covers ::isNotArray
     */
    public function testIsNotArray(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotArray();
    }

    /**
     * @covers ::isNotBool
     */
    public function testIsNotBool(): void {
        $matcher = $this->createMatcherWithActualValue([]);
        $matcher->isNotBool();
    }

    /**
     * @covers ::isNotFloat
     */
    public function testIsNotFloat(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotFloat();
    }

    /**
     * @covers ::isNotInt
     */
    public function testIsNotInt(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotInt();
    }

    /**
     * @covers ::isNotNumeric
     */
    public function testIsNotNumeric(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotNumeric();
    }

    /**
     * @covers ::isNotObject
     */
    public function testIsNotObject(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotObject();
    }

    /**
     * @covers ::isNotResource
     */
    public function testIsNotResource(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotResource();
    }

    /**
     * @covers ::isNotString
     */
    public function testIsNotString(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotString();
    }

    /**
     * @covers ::isNotScalar
     */
    public function testIsNotScalar(): void {
        $matcher = $this->createMatcherWithActualValue(new stdClass());
        $matcher->isNotScalar();
    }

    /**
     * @covers ::isNotCallable
     */
    public function testIsNotCallable(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotCallable();
    }

    /**
     * @covers ::isNotIterable
     */
    public function testIsNotIterable(): void {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isNotIterable();
    }

    /**
     * @covers ::isEqualTo
     */
    public function testIsEqualTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isEqualTo($this);
    }

    /**
     * @covers ::isEqualCanonicalizingTo
     */
    public function testIsEqualCanonicalizingTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isEqualCanonicalizingTo($this);
    }

    /**
     * @covers ::isEqualIgnoringCaseTo
     */
    public function testIsEqualIgnoringCaseTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isEqualIgnoringCaseTo($this);
    }

    /**
     * @covers ::isEqualWithDeltaTo
     */
    public function testIsEqualWithDeltaTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isEqualWithDeltaTo($this, 0.1);
    }

    /**
     * @covers ::isNotEqualTo
     */
    public function testIsNotEqualTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotEqualTo(null);
    }

    /**
     * @covers ::isNotEqualCanonicalizingTo
     */
    public function testIsNotEqualCanonicalizingTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotEqualCanonicalizingTo(null);
    }

    /**
     * @covers ::isNotEqualIgnoringCaseTo
     */
    public function testIsNotEqualIgnoringCaseTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotEqualIgnoringCaseTo(null);
    }

    /**
     * @covers ::isNotEqualWithDeltaTo
     */
    public function testIsNotEqualWithDeltaTo(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotEqualWithDeltaTo(null, 0.1);
    }

    /**
     * @covers ::isGreaterThan
     */
    public function testIsGreaterThan(): void {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isGreaterThan(2);
    }

    /**
     * @covers ::isLessThan
     */
    public function testIsLessThan(): void {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isLessThan(5);
    }

    /**
     * @covers ::isGreaterOrEqualTo
     */
    public function testIsGreaterOrEqualToGreaterPartWork(): void {
        $matcher = $this->createMatcherWithActualValue(10);
        $matcher->isGreaterOrEqualTo(5);
    }

    /**
     * @covers ::isGreaterOrEqualTo
     */
    public function testIsGreaterOrEqualToEqualPartWork(): void {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isGreaterOrEqualTo(3);
    }

    /**
     * @covers ::isLessOrEqualTo
     */
    public function testIsLessOrEqualToEqualPartWork(): void {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isLessOrEqualTo(3);
    }

    /**
     * @covers ::isLessOrEqualTo
     */
    public function testIsLessOrEqualToLessPartWork(): void {
        $matcher = $this->createMatcherWithActualValue(5);
        $matcher->isLessOrEqualTo(10);
    }

    /**
     * @covers ::isNull
     */
    public function testIsNull(): void {
        $matcher = $this->createMatcherWithActualValue(null);
        $matcher->isNull();
    }

    /**
     * @covers ::isNotNull
     */
    public function testIsNotNull(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotNull();
    }

    /**
     * @covers ::isEmpty
     */
    public function testIsEmpty(): void {
        $matcher = $this->createMatcherWithActualValue(null);
        $matcher->isEmpty();
    }

    /**
     * @covers ::isNotEmpty
     */
    public function testIsNotEmpty(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotEmpty();
    }

    /**
     * @covers ::isTheSameAs
     */
    public function testIsTheSameAs(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isTheSameAs($this);
    }

    /**
     * @covers ::isNotTheSameAs
     */
    public function testIsNotTheSameAs(): void {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotTheSameAs(new stdClass());
    }
}
