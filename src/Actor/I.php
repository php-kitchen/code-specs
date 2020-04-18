<?php

namespace PHPKitchen\CodeSpecs\Actor;

use PHPKitchen\CodeSpecs\Directive\Wait;
use PHPKitchen\CodeSpecs\Expectation\Routing\Router;

class I {
    public static function describe(string $scenario) {

    }

    public static function verify(string $scenario,  callable $verificationSteps = null) {

    }

    public static function expect(string $scenario,  callable $verificationSteps = null) {

    }

    public static function match(string $variableName) {

    }

    /**
     * Stops execution for specified number of units of time.
     *
     * @param int $numberOfTimeUnits number of units of time.
     * {@link Wait} specifies what unit should be used.
     *
     * @return Wait
     */
    public static function wait($numberOfTimeUnits): Wait {

    }

    public static function lookAt(string $variableName): Router {
        return new Router();
    }

    public static function usePlugin($plugin) {

    }
}
