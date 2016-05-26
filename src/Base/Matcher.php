<?php

namespace DeKey\Tester\Base;

/**
 * Matcher is a base class for all of the expectation matchers.
 *
 * @package DeKey\Tester\Base
 * @author Dmitry Kolodko
 */
abstract class Matcher implements ExpectationMatcher {
    /**
     * @var mixed actual value or variable that will be matched to expectations.
     */
    protected $actual;
    /**
     * @var string description of expectation. If expectation fails this description will be displayed in console.
     */
    protected $description;

    public function __construct($actual, $description = '') {
        $this->actual = $actual;
        $this->description = $description;
    }
}