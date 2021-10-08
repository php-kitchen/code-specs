<?php

namespace Tests\Base;

use PHPKitchen\CodeSpecs\Expectation\Internal\Assert;
use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;
use ReflectionClass;

/**
 * Represents base test for all of the matcher tests.
 * Provides common functionality of creating matcher instance.
 *
 * @author Dima Kolodko <dima@kolodko.pro>
 */
abstract class BaseMatcherTest extends TestCase {
    /**
     * @var string class of a matcher being tested.
     */
    protected $matcherClass;

    /**
     * Should be implemented to initialize {@link matcherClass}. Otherwise instantiation of a new matcher will fail.
     */
    abstract protected function initMatcherClass(): void;

    protected function setUp(): void {
        parent::setUp();
        $this->initMatcherClass();
    }

    protected function createMatcherWithActualValue($value) {
        $reflection = new ReflectionClass($this->matcherClass);
        $assert = new Assert(StepsList::getInstance(), $value, 'matcher does not work');

        return $reflection->newInstanceArgs([$assert]);
    }
}
