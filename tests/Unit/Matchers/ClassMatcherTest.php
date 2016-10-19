<?php
namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Matchers\ClassMatcher;
use Tests\DeKey\Tester\Base\BaseMatcherTest;

/**
 * Unit test for {@link ClassMatcher}
 *
 * @method ClassMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\ClassMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class ClassMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = ClassMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createMatcherWithActualValue(static::class);
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . ClassMatcher::class);
        }
    }

    /**
     * @covers ::isExist
     */
    public function testIsExist() {
        $class = $this->createMatcherWithActualValue(static::class);
        $class->isExist();
    }

    /**
     * @covers ::isNotExist
     */
    public function testIsNotExist() {
        $class = $this->createMatcherWithActualValue('not existing class');
        $class->isNotExist();
    }

    /**
     * @covers ::isInterface
     */
    public function testIsInterface() {
        $class = $this->createMatcherWithActualValue(TestInterface::class);
        $class->isInterface();
    }

    /**
     * @covers ::isNotInterface
     */
    public function testIsNotInterface() {
        $class = $this->createMatcherWithActualValue(static::class);
        $class->isNotInterface();
    }

    /**
     * @covers ::hasStaticAttribute
     */
    public function testHasStaticAttribute() {
        $class = $this->createMatcherWithActualValue(TestClass::class);
        $class->hasStaticAttribute('staticAttribute');
    }

    /**
     * @covers ::doesNotHaveStaticAttribute
     */
    public function testDoesNotHaveStaticAttribute() {
        $class = $this->createMatcherWithActualValue(TestClass::class);
        $class->doesNotHaveStaticAttribute('notExistingStaticAttribute');
    }

    /**
     * @covers ::hasAttribute
     */
    public function testHasAttribute() {
        $class = $this->createMatcherWithActualValue(TestClass::class);
        $class->hasAttribute('notStaticAttribute');
    }

    /**
     * @covers ::doesNotHaveAttribute
     */
    public function testDoesNotHaveAttribute() {
        $class = $this->createMatcherWithActualValue(TestClass::class);
        $class->doesNotHaveAttribute('notExistingAttribute');
    }
}

class TestClass {
    public static $staticAttribute;
    public $notStaticAttribute;
}

interface TestInterface {
}