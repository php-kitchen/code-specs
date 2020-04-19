<?php

namespace PHPKitchen\CodeSpecs\Base;

use PHPKitchen\CodeSpecs\Mixin\TesterInitialization;
use PHPUnit\Framework\TestCase;

/**
 * Represents a base class for all of the class behavior specifications(test cases).
 *
 * @codeCoverageIgnore
 *
 * @package PHPKitchen\CodeSpecs\Base
 * @author Dima Kolodko <dima@kolodko.pro>
 */
abstract class Specification extends TestCase {
    protected function clearSteps() {

    }
}