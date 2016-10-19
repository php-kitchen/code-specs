<?php

namespace DeKey\Tester\Contract;

use DeKey\Tester\TesterExpectation;

/**
 * Represents object designed to check actual value of variable matches expected.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
interface ExpectationMatcher {
    public function __construct(TesterExpectation $expectation, $actual, $description);
}