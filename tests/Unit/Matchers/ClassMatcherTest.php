<?php

namespace Tests\Unit\Matchers;

use Exception;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ClassMatcher;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link ClassMatcher}
 *
 * @method ClassMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\ClassMatcher
 *
 * @package Tests\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ClassMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass(): void {
        $this->matcherClass = ClassMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate(): void {
        try {
            $this->createMatcherWithActualValue(static::class);
            $matcherCreated = true;
        } catch (Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . ClassMatcher::class);
    }

    /**
     * @covers ::isExist
     */
    public function testIsExist(): void {
        $class = $this->createMatcherWithActualValue(static::class);
        $class->isExist();
    }

    /**
     * @covers ::isNotExist
     */
    public function testIsNotExist(): void {
        $class = $this->createMatcherWithActualValue('not existing class');
        $class->isNotExist();
    }

    /**
     * @covers ::isInterface
     */
    public function testIsInterface(): void {
        $class = $this->createMatcherWithActualValue(TestInterface::class);
        $class->isInterface();
    }

    /**
     * @covers ::isNotInterface
     */
    public function testIsNotInterface(): void {
        $class = $this->createMatcherWithActualValue(static::class);
        $class->isNotInterface();
    }

    /**
     * @covers ::hasStaticAttribute
     */
    public function testHasStaticAttribute(): void {
        $class = $this->createMatcherWithActualValue(TestClass::class);
        $class->hasStaticAttribute('staticAttribute');
    }

    /**
     * @covers ::doesNotHaveStaticAttribute
     */
    public function testDoesNotHaveStaticAttribute(): void {
        $class = $this->createMatcherWithActualValue(TestClass::class);
        $class->doesNotHaveStaticAttribute('notExistingStaticAttribute');
    }

    /**
     * @covers ::hasAttribute
     */
    public function testHasAttribute(): void {
        $class = $this->createMatcherWithActualValue(TestClass::class);
        $class->hasAttribute('notStaticAttribute');
    }

    /**
     * @covers ::doesNotHaveAttribute
     */
    public function testDoesNotHaveAttribute(): void {
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
