<?php

namespace Tests\DeKey\Tester\Base;

use DeKey\Tester\TesterExpectation;

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
     * @var TesterExpectation instance of expectation simply for matcher testing purpoces.
     */
    protected $expectation;

    /**
     * Should be implemented to initialize {@link matcherClass}. Otherwise instantiation of a new matcher will fail.
     */
    abstract protected function initMatcherClass();

    protected function setUp() {
        parent::setUp();
        $this->initMatcherClass();
    }

    protected function createMatcherWithActualValue($value) {
        $reflection = new \ReflectionClass($this->matcherClass);
        return $reflection->newInstanceArgs([$this->tester, $this, $value, 'matcher does not work']);
    }
}