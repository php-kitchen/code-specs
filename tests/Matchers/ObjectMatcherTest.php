<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\ObjectMatcher;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for {@link ObjectMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\ObjectMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class ObjectMatcherTest extends PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new ObjectMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . ObjectMatcher::class);
        }
    }

    /**
     * @covers ::isInstanceOf
     */
    public function testIsInstanceOf() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isInstanceOf(PHPUnit_Framework_TestCase::class);
    }

    /**
     * @covers ::isNotInstanceOf
     */
    public function testIsNotInstanceOf() {
        $matcher = $this->createMatcherWithActualValue($this);
        $matcher->isNotInstanceOf(\Exception::class);
    }

    /**
     * @covers ::hasAttribute
     */
    public function testHasAttribute() {
        $matcher = $this->createMatcherWithActualValue(new TestDataClass());
        $matcher->hasAttribute('publicAttribute');
        $matcher->hasAttribute('protectedAttribute');
    }

    /**
     * @covers ::doesNotHaveAttribute
     */
    public function testDoesNotHaveAttribute() {
        $matcher = $this->createMatcherWithActualValue(new TestDataClass());
        $matcher->doesNotHaveAttribute('notExistingAttribute');
    }

    protected function createMatcherWithActualValue($value) {
        return new ObjectMatcher($value, 'matcher does not work');
    }
}

class TestDataClass {
    public $publicAttribute;
    protected $protectedAttribute;
}