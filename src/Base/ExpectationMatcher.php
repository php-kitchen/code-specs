<?php

namespace DeKey\Tester\Base;

/**
 * Represents object designed to check actual value of variable matches expected.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko
 */
interface ExpectationMatcher {
    public function __construct($actual, $description);
}