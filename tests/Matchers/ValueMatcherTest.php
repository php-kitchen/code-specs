<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\ValueMatcher;

/**
 * Unit test for {@link ValueMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\ValueMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class ValueMatcherTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new ValueMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . ValueMatcher::class);
        }
    }

    /**
     * @covers ::isInternalType
     */
    public function testIsInternalType() {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isInternalType('boolean');
    }

    /**
     * @covers ::isNotInternalType
     */
    public function testIsNotInternalType() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotInternalType('boolean');
    }

    /**
     * @covers ::isEqualTo
     */
    public function testIsEqualTo() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isEqualTo($this);
    }

    /**
     * @covers ::isNotEqualTo
     */
    public function testIsNotEqualTo() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotEqualTo(null);
    }

    /**
     * @covers ::isGreaterThan
     */
    public function testIsGreaterThan() {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isGreaterThan(2);
    }

    /**
     * @covers ::isLessThan
     */
    public function testIsLessThan() {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isLessThan(5);
    }

    /**
     * @covers ::isGreaterOrEqualTo
     */
    public function testIsGreaterOrEqualToGreaterPartWork() {
        $matcher = $this->createMatcherWithActualValue(10);
        $matcher->isGreaterOrEqualTo(5);
    }

    /**
     * @covers ::isGreaterOrEqualTo
     */
    public function testIsGreaterOrEqualToEqualPartWork() {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isGreaterOrEqualTo(3);
    }

    /**
     * @covers ::isLessOrEqualTo
     */
    public function testIsLessOrEqualToEqualPartWork() {
        $matcher = $this->createMatcherWithActualValue(3);
        $matcher->isLessOrEqualTo(3);
    }

    /**
     * @covers ::isLessOrEqualTo
     */
    public function testIsLessOrEqualToLessPartWork() {
        $matcher = $this->createMatcherWithActualValue(5);
        $matcher->isLessOrEqualTo(10);
    }

    /**
     * @covers ::isNull
     */
    public function testIsNull() {
        $matcher = $this->createMatcherWithActualValue(null);
        $matcher->isNull();
    }

    /**
     * @covers ::isNotNull
     */
    public function testIsNotNull() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotNull();
    }

    /**
     * @covers ::isEmpty
     */
    public function testIsEmpty() {
        $matcher = $this->createMatcherWithActualValue(null);
        $matcher->isEmpty();
    }

    /**
     * @covers ::isNotEmpty
     */
    public function testIsNotEmpty() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotEmpty();
    }

    /**
     * @covers ::isTheSameAs
     */
    public function testIsTheSameAs() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isTheSameAs($this);
    }

    /**
     * @covers ::isNotTheSameAs
     */
    public function testIsNotTheSameAs() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotTheSameAs(new \stdClass());
    }

    protected function createMatcherWithActualValue($value) {
        return new ValueMatcher($value, 'matcher does not work');
    }
}