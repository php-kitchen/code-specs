<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\ClassMatcher;

/**
 * Unit test for {@link ClassMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\ClassMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class ClassMatcherTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new ClassMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . ClassMatcher::class);
        }
    }

    /**
     * @covers ::isExist
     */
    public function testIsExist() {
        $matcher = $this->createMatcherWithActualValue(static::class);
        $matcher->isExist();
    }

    /**
     * @covers ::isNotExist
     */
    public function testIsNotExist() {
        $matcher = $this->createMatcherWithActualValue('not existing class');
        $matcher->isNotExist();
    }

    /**
     * @covers ::isInterface
     */
    public function testIsInterface() {
        $matcher = $this->createMatcherWithActualValue(TestInterface::class);
        $matcher->isInterface();
    }

    /**
     * @covers ::isNotInterface
     */
    public function testIsNotInterface() {
        $matcher = $this->createMatcherWithActualValue(static::class);
        $matcher->isNotInterface();
    }

    /**
     * @covers ::hasStaticAttribute
     */
    public function testHasStaticAttribute() {
        $matcher = $this->createMatcherWithActualValue(TestClass::class);
        $matcher->hasStaticAttribute('staticAttribute');
    }

    /**
     * @covers ::doesNotHaveStaticAttribute
     */
    public function testDoesNotHaveStaticAttribute() {
        $matcher = $this->createMatcherWithActualValue(TestClass::class);
        $matcher->doesNotHaveStaticAttribute('notExistingStaticAttribute');
    }

    /**
     * @covers ::hasStaticAttribute
     */
    public function testHasAttribute() {
        $matcher = $this->createMatcherWithActualValue(TestClass::class);
        $matcher->hasAttribute('notStaticAttribute');
    }

    /**
     * @covers ::doesNotHaveStaticAttribute
     */
    public function testDoesNotHaveAttribute() {
        $matcher = $this->createMatcherWithActualValue(TestClass::class);
        $matcher->doesNotHaveAttribute('notExistingAttribute');
    }

    protected function createMatcherWithActualValue($value) {
        return new ClassMatcher($value, 'matcher does not work');
    }
}

class TestClass {
    public static $staticAttribute;
    public $notStaticAttribute;
}

interface TestInterface {

}