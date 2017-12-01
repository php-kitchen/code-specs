<?php

namespace PHPKitchen\CodeSpecs\Mixin;

use PHPKitchen\CodeSpecs\Contract\TestGuy;
use PHPKitchen\CodeSpecs\Directive\Wait;
use PHPKitchen\CodeSpecs\Expectation\Dispatcher\DelayedDispatcher;
use PHPKitchen\CodeSpecs\Expectation\Dispatcher\Dispatcher;
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
 * Represents common expectation methods that can be used in test guy implementation.
 *
 * @codeCoverageIgnore
 *
 * @package PHPKitchen\CodeSpecs\Mixins
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
trait TestGuyMethods {
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
     * Specifies scenario test guy is working on.
     *
     * @param string $scenario scenario name.
     * Scenario should be a logical ending of "I describe ". For example: "process of user registration".
     * Such scenario would result in "I describe process of user registration" output in console.
     * @return $this
     */
    public function describe(string $scenario): TestGuy {
        $this->steps->add('I describe ' . $scenario);
        return $this;
    }

    /**
     * Specifies what test guy expects from a set of matchers that would be defined next in the
     * specification.
     *
     * @param string $expectation expectation text.
     * Expectation should be a logical ending of "I expect that ". For example: "user is added to the DB".
     * Such scenario would result in "I expect that user is added to the DB" output in console.
     * @return $this
     */
    public function expectThat(string $expectation): TestGuy {
        $this->steps->add('I expect that ' . $expectation);

        return $this;
    }

    /**
     * Specifies what test guy expects from a set of matchers that would be defined next in the
     * specification.
     *
     * @param string $expectation expectation text.
     * Expectation should be a logical ending of "I expect to ". For example: "see user in the DB".
     * Such scenario would result in "I expect to see user in the DB" output in console.
     * @param callable $verificationSteps callable function with following definition "function (TestGuy $I) { ..." that contains a group of
     * expectations united by one verification topic. All of the expectations would be executed once they
     * are defined.
     * @return $this
     */
    public function verifyThat(string $expectation, callable $verificationSteps = null): TestGuy {
        $this->steps->add('I verify that ' . $expectation);
        if ($verificationSteps) {
            $verificationSteps($this);
        }

        return $this;
    }

    /**
     * Specifies name of a variable test guy would check.
     *
     * @param string $variableName name of a variable to look at.
     * @return TestGuy
     */
    public function lookAt(string $variableName): TestGuy {
        $this->variableName = $variableName;
        return $this;
    }

    /**
     * Creates runtime matcher that you can use to perform typical asserts.
     * Runtime matcher is an object that represents a set of asserts from a typical matcher that
     * aren't executed at a time they were defined but would be executed every time runtime matcher object
     * would be called as a function with one argument - value to assert.
     *
     * For example:
     * <code>
     *  $userHasName = $I->match('user')->isArray()->isNotEmpty()->hasKey('name');
     *  $userHasName($admin);
     *  $userHasName($member);
     * </code>
     *
     * @param string $variableName name of a variable to look at.
     * @return \PHPKitchen\CodeSpecs\Expectation\Dispatcher\DelayedDispatcher
     */
    public function match(string $variableName): DelayedDispatcher {
        $this->variableName = $variableName;
        return $this->createDispatcher(DelayedDispatcher::class, null);
    }

    /**
     * Stops execution for specified number of units of time.
     *
     * @param int $numberOfTimeUnits number of units of time.
     * {@link Wait} specifies what unit should be used.
     *
     * @return Wait
     */
    public function wait($numberOfTimeUnits): Wait {
        return new Wait($numberOfTimeUnits, $this->steps);
    }

    /**
     * Starts a chain of asserts from {@link ValueMatcher}.
     *
     * @param mixed $variable variable to be tested
     * @return \PHPKitchen\CodeSpecs\Expectation\Matcher\ValueMatcher
     */
    public function see($variable): ValueMatcher {
        return $this->dispatch($variable)
            ->isMixed();
    }

    /**
     * Starts a chain of asserts from {@link StringMatcher}.
     *
     * @param string $variable variable to be tested
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