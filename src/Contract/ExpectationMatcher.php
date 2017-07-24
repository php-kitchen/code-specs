<?php

namespace DeKey\Tester\Contract;

use DeKey\Tester\Specification\Tester;
use PHPUnit\Framework\Test;

/**
 * Represents object designed to check actual value of variable matches expected.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
interface ExpectationMatcher {
    public function __construct(Tester $module, Test $test, $actual, $description);
}