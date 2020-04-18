<?php

namespace Tests\Base;

use PHPKitchen\CodeSpecs\Expectation\Internal\Assert;
use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;

/**
 * Represents base test for all of the matcher tests.
 * Provides common functionality of creating matcher instance.
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
abstract class BaseMatcherTest extends TestCase {
    /**
     * @var string class of a matcher being tested.
     */
    protected $matcherClass;

    /**
     * Should be implemented to initialize {@link matcherClass}. Otherwise instantiation of a new matcher will fail.
     */
    abstract protected function initMatcherClass();

    protected function setUp(): void {
        parent::setUp();
        $this->initMatcherClass();
    }

    protected function createMatcherWithActualValue($value) {
        $reflection = new \ReflectionClass($this->matcherClass);
        $assert = new Assert(StepsList::getInstance(), $this, $value, 'matcher does not work');

        return $reflection->newInstanceArgs([$assert]);
    }
}