<?php

namespace DeKey\Tester\Base;

use DeKey\Tester\Contract\ExpectationMatcher;
use DeKey\Tester\TesterExpectation;

/**
 * Matcher is a base class for all of the expectation matchers.
 *
 * @method TesterExpectation and() magic method that allows to access expectation methods to chain
 * matchers like:
 * <pre>
 * $expectation->valueOf($a)->isEqualTo($b)->and()->valueOf($c)->idEqualTo($b);
 * <pre/>
 *
 * @package DeKey\Tester\Base
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
abstract class Matcher implements ExpectationMatcher {
    /**
     * @var mixed actual value or variable that will be matched to expectations.
     */
    protected $actual;
    /**
     * @var mixed actual value or variable that will be matched to expectations.
     */
    protected $expectation;
    /**
     * @var string description of expectation. If expectation fails this description will be displayed in console.
     */
    protected $description;

    public function __construct(TesterExpectation $expectation, $actual, $description = '') {
        $this->expectation = $expectation;
        $this->actual = $actual;
        $this->description = $description;
    }

    public function __call($name, $arguments) {
        if ($name === 'and') {
            $result = $this->expectation;
        } else {
            throw new \BadMethodCallException();
        }
        return $result;
    }

    /**
     * Just a shortcut method to improve readability in some of use-cases.
     *
     * @return $this
     */
    public function that() {
        return $this;
    }
}