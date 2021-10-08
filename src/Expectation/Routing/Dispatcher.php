<?php

namespace PHPKitchen\CodeSpecs\Expectation\Routing;

use PHPKitchen\CodeSpecs\Contract\ExpectationMatcher;
use PHPKitchen\CodeSpecs\Expectation\Internal\Assert;
use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ArrayMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\BooleanMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ClassMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\DirectoryMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\FileMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\NumberMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\StringMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ValueMatcher;

/**
 * Represents matchers dispatcher.
 *
 * Required to dispatch asserts to specific matchers.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class Dispatcher {
    /**
     * @var mixed actual value or variable that will be matched to expectations.
     */
    protected $actual;
    /**
     * @var string description of expectation. If expectation fails this description will be displayed in console.
     */
    protected $variableName;
    protected $deferAsserts = false;

    public function __construct($actual, $variableName = '', $deferAsserts) {
        $this->actual = $actual;
        $this->variableName = $variableName;
        $this->deferAsserts = $deferAsserts;
        $this->init();
    }

    /**
     * Override this method if you want to initialize anything after constructor.
     */
    protected function init(): void {
    }

    public function isMixed(): ValueMatcher {
        return $this->createMatcher(ValueMatcher::class, 'value');
    }

    public function isString(): StringMatcher {
        return $this->createMatcher(StringMatcher::class, 'boolean');
    }

    public function isArray(): ArrayMatcher {
        return $this->createMatcher(ArrayMatcher::class, 'array');
    }

    public function isBoolean(): BooleanMatcher {
        return $this->createMatcher(BooleanMatcher::class, 'boolean');
    }

    public function isNumber(): NumberMatcher {
        return $this->createMatcher(NumberMatcher::class, 'number');
    }

    public function isObject(): ObjectMatcher {
        return $this->createMatcher(ObjectMatcher::class, 'object');
    }

    public function isClass(): ClassMatcher {
        return $this->createMatcher(ClassMatcher::class, 'class');
    }

    public function isFile(): FileMatcher {
        return $this->createMatcher(FileMatcher::class, 'file');
    }

    public function isDirectory(): DirectoryMatcher {
        return $this->createMatcher(DirectoryMatcher::class, 'directory');
    }

    protected function createMatcher($className, $id): ExpectationMatcher {
        $variableName = $this->variableName ?: $id;

        $stepsList = StepsList::getInstance();
        $assert = new Assert($stepsList, $this->actual, "I see that {$variableName}");

        if ($this->deferAsserts) {
            $assert->switchToDelayedExecutionStrategy();
        }

        return new $className($assert);
    }
}
