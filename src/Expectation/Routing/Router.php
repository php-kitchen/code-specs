<?php

namespace PHPKitchen\CodeSpecs\Expectation\Routing;

use PHPKitchen\CodeSpecs\Contract\TestGuy;
use PHPKitchen\CodeSpecs\Directive\Wait;
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
use PHPKitchen\CodeSpecs\Mixin\TestGuyMethods;

class Router {
    /**
     * @var StepsList
     */
    private $steps;
    /**
     * @var \PHPUnit\Framework\Test
     */
    protected $context;
    protected $variableName = '';
    //region ----------------------- SPECIFICATION METHODS -----------------------

    /**
     * Starts a chain of asserts from {@link StringMatcher}.
     *
     * @param string $variable variable to be tested
     *
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\StringMatcher
     */
    public function seeString($string): StringMatcher {
        return $this->dispatch($string)
                    ->isString();
    }

    /**
     * Starts a chain of asserts from {@link ArrayMatcher}.
     *
     * @param array|\ArrayAccess $variable variable to be tested
     *
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\ArrayMatcher
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
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\BooleanMatcher
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
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\NumberMatcher
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
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher
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
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\ClassMatcher
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
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\FileMatcher
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
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\DirectoryMatcher
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
        return $this->createDispatcher(Dispatcher::class, $actualValue);
    }

    private function createDispatcher($class, $actualValue): Dispatcher {
        $dispatcher = new $class($this->context, $actualValue, $this->variableName);
        $this->variableName = '';

        return $dispatcher;
    }
    //endregion
}