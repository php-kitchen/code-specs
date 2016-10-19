<?php

namespace DeKey\Tester;


use DeKey\Tester\Contract\TestGuy;
use PHPUnit_Framework_TestCase as TestCase; // using this awful class for backward compatibility with. In text major release  will be replaced with {@link PHPUnit\Framework\TestCase}

/**
 * UnitTester is a simple class designed to make PHPUnit tests more readable using BDD-style
 * syntax. UnitTester represents a test-guy who is testing your code, so tests writes as a story
 * of what tester is doing. Example:
 * <pre>
 * // do stuff
 * .......
 * $tester = $this->tester;
 * $tester->checksSpecification('user activates processor for PDF transformation to HTML')
 *      ->expectsThat('processor converts PDF to HTML and return HTML representation of given PDF.')
 *      ->variable($processedContent)
 *      ->isEqualTo(self::EXPECTED_CONTENT);
 * </pre>
 *
 * @package DeKey\Tester
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class UnitTester implements TestGuy {
    /**
     * @var string scenario Tester currently checks. There can be only one scenario and several {@link expectation}s.
     */
    protected $scenario;
    /**
     * @var string tester name that will be used to generate expectation message
     */
    protected $name;
    /**
     * @var string expectation class being used in {@link createExpectation()}
     */
    protected $expectationClass;
    /**
     * @var TestCase test case tester being used in.
     */
    protected $test;

    public function __construct(TestCase $test, $testerName = 'Tester', $expectationClass = TesterExpectation::class) {
        $this->test = $test;
        $this->name = $testerName;
        $this->expectationClass = $expectationClass;
    }

    /**
     * @inheritdoc
     */
    public function checksScenario($scenario) {
        $this->scenario = 'Scenario: ' . $scenario . PHP_EOL;

        return $this;
    }
    /**
     * @inheritdoc
     * @return TesterExpectation
     */
    public function expectsThat($expectation = '') {
        if ($expectation) {
            $expectation = $this->name . ' expects that ' . $expectation;
        }
        return $this->createExpectation($expectation);
    }
    /**
     * @inheritdoc
     * @return TesterExpectation
     */
    public function expectsTo($expectation = '') {
        if ($expectation) {
            $expectation = $this->name . ' expects to ' . $expectation;
        }
        return $this->createExpectation($expectation);
    }

    protected function createExpectation($expectationMessage) {
        if (!empty($expectationMessage) || !empty($this->scenario)) {
            $constructorArguments = [$this->test, $this->scenario . $expectationMessage];
        } else {
            $constructorArguments = [$this->test];
        }
        $matcherReflection = new \ReflectionClass($this->expectationClass);
        return $matcherReflection->newInstanceArgs($constructorArguments);
    }
}