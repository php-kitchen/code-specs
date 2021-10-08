<?php

namespace PHPKitchen\CodeSpecs\Expectation\Routing;

use ArrayAccess;
use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ArrayMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\BooleanMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ClassMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\DirectoryMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\FileMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\NumberMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\StringMatcher;

/**
 * Represents dispatcher router.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class Router {
    public const IN_TIME_EXPECTATION_MODE = 1;
    public const DEFERRED_EXPECTATION_MODE = 0;
    protected $variableName = '';
    protected $mode;

    public function __construct(string $variableName, int $mode = self::IN_TIME_EXPECTATION_MODE) {
        $this->variableName = $variableName;
        $this->mode = $mode;
    }
    //region ----------------------- SPECIFICATION METHODS -----------------------

    /**
     * Starts a chain of asserts from {@link StringMatcher}.
     *
     * @param string $variable variable to be tested
     *
     * @return StringMatcher
     */
    public function seeString($variable): StringMatcher {
        return $this->dispatch($variable)
                    ->isString();
    }

    /**
     * Starts a chain of asserts from {@link ArrayMatcher}.
     *
     * @param array|ArrayAccess $variable variable to be tested
     *
     * @return ArrayMatcher
     */
    public function seeArray($variable): ArrayMatcher {
        return $this->dispatch($variable)
                    ->isArray();
    }

    /**
     * Starts a chain of asserts from {@link BooleanMatcher}.
     *
     * @param boolean $variable variable to be tested
     *
     * @return BooleanMatcher
     */
    public function seeBool($variable): BooleanMatcher {
        return $this->dispatch($variable)
            ->isBoolean();
    }

    /**
     * Starts a chain of asserts from {@link NumberMatcher}.
     *
     * @param int|float $variable variable to be tested
     *
     * @return NumberMatcher
     */
    public function seeNumber($variable): NumberMatcher {
        return $this->dispatch($variable)
            ->isNumber();
    }

    /**
     * Starts a chain of asserts from {@link ObjectMatcher}.
     *
     * @param object $variable variable to be tested
     *
     * @return ObjectMatcher
     */
    public function seeObject($variable): ObjectMatcher {
        return $this->dispatch($variable)
            ->isObject();
    }

    /**
     * Starts a chain of asserts from {@link ClassMatcher}.
     *
     * @param string $variable variable to be tested
     *
     * @return ClassMatcher
     */
    public function seeClass($variable): ClassMatcher {
        return $this->dispatch($variable)
            ->isClass();
    }

    /**
     * Starts a chain of asserts from {@link FileMatcher}.
     *
     * @param string $variable variable to be tested
     *
     * @return FileMatcher
     */
    public function seeFile($variable): FileMatcher {
        return $this->dispatch($variable)
            ->isFile();
    }

    /**
     * Starts a chain of asserts from {@link DirectoryMatcher}.
     *
     * @param string $variable variable to be tested
     *
     * @return DirectoryMatcher
     */
    public function seeDirectory($variable): DirectoryMatcher {
        return $this->dispatch($variable)
            ->isDirectory();
    }
    //endregion

    //region ----------------------- UTIL METHODS -----------------------

    protected function initStepsList() {
        $this->steps = StepsList::getInstance();
        $this->steps->clear();
    }

    private function dispatch($actualValue): Dispatcher {
        $dispatcher = new Dispatcher($actualValue, $this->variableName, $this->mode);
        $this->variableName = '';

        return $dispatcher;
    }
    //endregion
}
