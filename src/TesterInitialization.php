<?php

namespace PHPKitchen\CodeSpecs;

use PHPKitchen\CodeSpecs\Mixin\TesterInitialization as MainTesterInitialization;

/**
 * Adds support of {@link Tester} in PHPUnit test classes.
 *
 * @deprecated use {@link PHPKitchen\CodeSpecs\Mixin\TesterInitialization} instead.
 * This version kept for BC and would be removed in next major release.
 *
 * @package PHPKitchen\CodeSpecs
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
trait TesterInitialization {
    use MainTesterInitialization;
}