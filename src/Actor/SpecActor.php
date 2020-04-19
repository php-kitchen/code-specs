<?php

namespace PHPKitchen\CodeSpecs\Actor;

use PHPKitchen\CodeSpecs\Directive\Wait;
use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;
use PHPKitchen\CodeSpecs\Expectation\Routing\Router;

class SpecActor {
    public static function describe(string $scenario): void {

    }

    public static function verify(string $scenario, callable $verificationSteps = null): void {

    }

    public static function expect(string $scenario, callable $verificationSteps = null): void {

    }

    public static function match(string $variableName): Router {
        return new Router($variableName, Router::DEFERRED_EXPECTATION_MODE);
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
        return new Wait($numberOfTimeUnits, StepsList::getInstance());
    }

    public static function lookAt(string $variableName): Router {
        return new Router($variableName);
    }

    public static function usePlugin($plugin) {

    }
}