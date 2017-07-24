<?php

namespace DeKey\Tester\Specification;

use DeKey\Tester\TesterInitialization;
use PHPUnit\Framework\TestCase;

/**
 * Represents a base class for all of the class behavior specifications(test cases).
 *
 * @package DeKey\Tester
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
abstract class Specification extends TestCase {
    use TesterInitialization;
}