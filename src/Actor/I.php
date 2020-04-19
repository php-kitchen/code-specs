<?php

namespace PHPKitchen\CodeSpecs\Actor;

use PHPKitchen\CodeSpecs\Directive\Wait;
use PHPKitchen\CodeSpecs\Expectation\Routing\Router;

/**
 * Spec Actor
 *
 * @method static void describe(string $scenario)
 * @method static void verify(string $scenario, callable $verificationSteps = null)
 * @method static void expect(string $scenario, callable $verificationSteps = null)
 * @method static Router match(string $variableName)
 * @method static Router lookAt(string $variableName)
 * @method static Wait wait($numberOfTimeUnits)
 * @method static void usePlugin($plugin)
 *
 * @package PHPKitchen\CodeSpecs\Actor
 */
class I {
    private static $actor = SpecActor::class;

    public static function __callStatic($name, $arguments) {
        $actor = static::getActor();
        if (method_exists($actor, $name)) {
            return $actor->{$name}(...$arguments);
        }
        throw new \BadMethodCallException("Method {$name} does not exist at " . self::class);
    }

    private static function getActor(): SpecActor {
        if (is_string(self::$actor)) {
            self::$actor = new self::$actor;
        }

        return self::$actor;
    }

    public static function changeActor($actor) {
        self::$actor = $actor;
    }
}
