<?php

namespace DeKey\Tester\Specification;

use DeKey\Tester\Contract\ExpectationMatcher;
use DeKey\Tester\Matchers\ArrayMatcher;
use DeKey\Tester\Matchers\BooleanMatcher;
use DeKey\Tester\Matchers\ClassMatcher;
use DeKey\Tester\Matchers\DirectoryMatcher;
use DeKey\Tester\Matchers\FileMatcher;
use DeKey\Tester\Matchers\NumberMatcher;
use DeKey\Tester\Matchers\ObjectMatcher;
use DeKey\Tester\Matchers\StringMatcher;
use DeKey\Tester\Matchers\ValueMatcher;
use DeKey\Tester\TesterExpectation;
use PHPUnit\Framework\TestCase;

/**
 * Tester is a simple class designed to make PHPUnit tests more readable using BDD-style
 * syntax. Tester represents a test-guy who is testing your code, so tests writes as a story
 * of what tester is doing. Example:
 * <pre>
 * // do stuff
 * .......
 * $I = $this->tester;
 * $I->describe('how user activates processor for PDF transformation to HTML');
 * $I->expectsThat('processor converts PDF to HTML and return HTML representation of given PDF.');
 * $I->seeThatString($processedContent)
 *      ->isEqualTo(self::EXPECTED_CONTENT);
 * </pre>
 *
 * @package DeKey\Tester
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class Tester {
    /**
     * @var Step[]
     */
    private $steps = [];
    /**
     * @var TestCase the test case Tester being used in
     */
    private $context;

    public function __construct(TestCase $test) {
        $this->context = $test;
        $this->expectationClass = TesterExpectation::class;
    }

    //region ----------------------- SPECIFICATION METHODS -----------------------

    public function describe($scenario): self {
        $this->addStep('I describe ' . $scenario);
        return $this;
    }

    public function expectThat($expectation): self {
        $this->addStep('I expect that ' . $expectation);

        return $this;
    }

    public function expectTo($expectation): self {
        $this->addStep('I expect to ' . $expectation);
        return $this;
    }

    public function verifyThat($expectation): self {
        $this->addStep('I verify that ' . $expectation);
        return $this;
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param mixed $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\ValueMatcher
     */
    public function seeThatValueOf(...$params): ValueMatcher {
        return $this->createMatcher(ValueMatcher::class, 'value', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param string $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\StringMatcher
     */
    public function seeThatString(...$params): StringMatcher {
        return $this->createMatcher(StringMatcher::class, 'boolean', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param array|\ArrayAccess $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\ArrayMatcher
     */
    public function seeThatArray(...$params): ArrayMatcher {
        return $this->createMatcher(ArrayMatcher::class, 'array', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param boolean $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\BooleanMatcher
     */
    public function seeThatBoolean(...$params): BooleanMatcher {
        return $this->createMatcher(BooleanMatcher::class, 'boolean', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param int|float $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\NumberMatcher
     */
    public function seeThatNumber(...$params): NumberMatcher {
        return $this->createMatcher(NumberMatcher::class, 'number', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param object $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\ObjectMatcher
     */
    public function seeThatObject(...$params): ObjectMatcher {
        return $this->createMatcher(ObjectMatcher::class, 'object', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param string $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\ClassMatcher
     */
    public function seeThatClass(...$params): ClassMatcher {
        return $this->createMatcher(ClassMatcher::class, 'class', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param string $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\FileMatcher
     */
    public function seeThatFile(...$params): FileMatcher {
        return $this->createMatcher(FileMatcher::class, 'file', $params);
    }

    /**
     * @param string $variableNameOrVariable variable to be tested or it's name
     * @param string $variable variable to be tested (optional)
     * @return \DeKey\Tester\Matchers\DirectoryMatcher
     */
    public function seeThatDirectory(...$params): DirectoryMatcher {
        return $this->createMatcher(DirectoryMatcher::class, 'directory', $params);
    }

    protected function createMatcher($className, $id, $params): ExpectationMatcher {
        [$variableName, $variable] = $this->parseVariableAndNameFromParams($params, $id);

        return new $className($this, $this->context, $variable, "I see that {$variableName}");
    }

    protected function parseVariableAndNameFromParams($params, $variableDefaultName): array {
        if (count($params) >= 2) {
            [$variableName, $variable] = $params;
        } elseif (count($params) == 1) {
            $variable = $params[0];
            $variableName = $variableDefaultName;
        } else {
            throw new \InvalidArgumentException();
        }
        return [$variableName, $variable];
    }

    //endregion

    //region ----------------------- UTIL METHODS -----------------------

    public function addStep($step): void {
        $lastStep = end($this->steps);
        if ($lastStep) {
            $lastStep->check();
        }
        $this->steps[] = new Step($step);
    }

    public function getStepsListAsString(): string {
        $message = implode(PHP_EOL, $this->steps);
        $message = $message ? $message . PHP_EOL : $message;
        return (string)$message;
    }
    //endregion

    //region BC code. All of the methods are deprecated and would be removed

    /**
     * @deprecated use {@link describe}
     */
    public function checksScenario($scenario) {
        return $this->describe($scenario);
    }

    /**
     * @deprecated use {@link expectThat}
     * @return TesterExpectation
     */
    public function expectsThat($expectation = '') {
        if ($expectation) {
            $this->addStep("I expect that {$expectation}");
        }
        return $this->createExpectation($expectation);
    }

    /**
     * @deprecated use {@link expectThat}
     * @return TesterExpectation
     */
    public function expectsTo($expectation = '') {
        if ($expectation) {
            $this->addStep("I expect to {$expectation}");
        }
        return $this->createExpectation($expectation);
    }

    /**
     * @deprecated
     */
    protected function createExpectation($expectationMessage) {
        return new TesterExpectation($this, $this->context, $expectationMessage);
    }
    //endregion
}