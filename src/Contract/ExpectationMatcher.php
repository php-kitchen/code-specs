<?php

namespace PHPKitchen\CodeSpecs\Contract;

use PHPKitchen\CodeSpecs\Expectation\Internal\Assert;

/**
 * Represents object designed to check actual value of variable matches expected.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
interface ExpectationMatcher {
    public function __construct(Assert $assert);
}
