<?php

namespace DeKey\Tester\Matchers\Base;

use DeKey\Tester\Contract\ExpectationMatcher;
use DeKey\Tester\Specification\Tester;
use PHPUnit\Framework\Test;

/**
 * Matcher is a base class for all of the expectation matchers.
 *
 * @package DeKey\Tester\Base
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
abstract class Matcher implements ExpectationMatcher {
    /**
     * @var mixed actual value or variable that will be matched to expectations.
     */
    protected $actual;
    /**
     * @var Tester actor who run the matcher
     */
    protected $actor;
    /**
     * @var \PHPUnit\Framework\TestCase test case matcher being used in
     */
    protected $test;
    /**
     * @var string description of expectation. If expectation fails this description will be displayed in console.
     */
    protected $description;

    public function __construct(Tester $module, Test $test, $actual, $description = '') {
        $this->actor = $module;
        $this->test = $test;
        $this->actual = $actual;
        $this->description = $description;
    }

    protected function registerExpectation($message) {
        $this->actor->addStep("$this->description {$message}.");
    }

    protected function getMessageForAssert() {
        return $this->actor->getStepsListAsString();
    }
}