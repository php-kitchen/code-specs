<?php

namespace PHPKitchen\CodeSpecs\Integration\Codeception;

use Codeception\Module;
use Codeception\TestInterface;
use PHPKitchen\CodeSpecs\Contract\TestGuy;
use PHPKitchen\CodeSpecs\Mixin\TestGuyMethods;

/**
 * Represents a Codeception module that add a bunch of cool methods to "Actor" for unit testing
 * and show a way of representing unit tests as a behavior specifications of a specific class
 * and a test of specific method as a specification of the method.
 *
 * @package PHPKitchen\CodeSpecs\Integration\Codeception
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class CodeSpecs extends Module implements TestGuy {
    use TestGuyMethods;

    //region ----------------------- UTIL METHODS -----------------------

    public function _before(TestInterface $test) {
        $this->context = $test;
        $this->initStepsList();

        parent::_before($test);
    }

    //endregion
}