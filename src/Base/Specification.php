<?php

namespace PHPKitchen\CodeSpecs\Base;

use PHPUnit\Framework\TestCase;
use PHPKitchen\CodeSpecs\Mixin\TesterInitialization;

/**
 * Represents a base class for all of the class behavior specifications(test cases).
 *
 * @package PHPKitchen\CodeSpecs\Base
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
abstract class Specification extends TestCase {
    use TesterInitialization;
}