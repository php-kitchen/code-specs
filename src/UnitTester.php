<?php

namespace DeKey\Tester;

use DeKey\Tester\Base\ExpectationMatcher;
use DeKey\Tester\Matchers\ArrayMatcher;
use DeKey\Tester\Matchers\BooleanMatcher;
use DeKey\Tester\Matchers\ClassMatcher;
use DeKey\Tester\Matchers\ExceptionMatcher;
use DeKey\Tester\Matchers\FileMatcher;
use DeKey\Tester\Matchers\ObjectMatcher;
use DeKey\Tester\Matchers\StringMatcher;
use DeKey\Tester\Matchers\ValueMatcher;
use PHPUnit_Framework_TestCase;

/**
 * UnitTester is a simple class designed to make PHPUnit tests more readable using BDD-style
 * syntax. UnitTester represents a test-guy who is testing your code, so tests writes as a story
 * of what tester is doing. Example:
 * <pre>
 * // do some stuff
 * .......
 * $tester = $this->tester;
 * $tester->checksSpecification('Some processor generates some files and and returns execution result.')
 *      ->expectsThat('processor return valid content of some data.')
 *      ->variable($processedContent)
 *      ->isEqualTo(self::EXPECTED_CONTENT);
 * </pre>
 *
 * @package DeKey\Tester
 * @author Dmitry Kolodko
 */
class UnitTester {
    /**
     * @var string scenario Tester currently checks. There can be only one scenario and several {@link expectation}s.
     */
    protected $scenario;
    /**
     * @var string message indicates what tester expects to test.
     */
    protected $expectation;
    /**
     * @var PHPUnit_Framework_TestCase test case tester being used in.
     */
    protected $test;
    /**
     * @var string tester name that will be used to generate expectation message
     */
    protected $name;

    public function __construct(PHPUnit_Framework_TestCase $test, $testerName = 'Tester') {
        $this->test = $test;
        $this->name = $testerName;
    }

    public function checksScenario($scenario) {
        $this->scenario = 'Scenario: ' . $scenario . PHP_EOL;

        return $this;
    }

    public function expectsThat($expectation = '') {
        if ($expectation) {
            $this->expectation = $this->name . ' expects that ' . $expectation;
        }
        return $this;
    }

    public function expectsTo($expectation = '') {
        if ($expectation) {
            $this->expectation = $this->name . ' expects to ' . $expectation;
        }
        return $this;
    }

    /**
     * @param mixed $value actual value
     * @return ValueMatcher matcher responsible for value expectations handling.
     */
    public function valueOf($value) {
        return $this->createExpectationMatcher(ValueMatcher::class, $value);
    }

    /**
     * @param mixed $variable actual variable
     * @return BooleanMatcher matcher responsible for variable expectations handling.
     */
    public function boolean($variable) {
        return $this->createExpectationMatcher(BooleanMatcher::class, $variable);
    }

    /**
     * @param mixed $variable actual variable
     * @return StringMatcher matcher responsible for variable expectations handling.
     */
    public function string($variable) {
        return $this->createExpectationMatcher(StringMatcher::class, $variable);
    }

    /**
     * @param mixed $variable actual variable
     * @return ArrayMatcher matcher responsible for variable expectations handling.
     */
    public function theArray($variable) {
        return $this->createExpectationMatcher(ArrayMatcher::class, $variable);
    }

    /**
     * @param object $object actual object
     * @return ObjectMatcher matcher responsible for object expectations handling.
     */
    public function object($object) {
        return $this->createExpectationMatcher(ObjectMatcher::class, $object);
    }

    /**
     * @param \Exception $exception actual exception
     * @return ExceptionMatcher matcher responsible for exception expectations handling.
     */
    public function exception($exception) {
        return $this->createExpectationMatcher(ExceptionMatcher::class, $exception);
    }

    /**
     * @param object $class actual class
     * @return ClassMatcher matcher responsible for object expectations handling.
     */
    public function theClass($class) {
        return $this->createExpectationMatcher(ClassMatcher::class, $class);
    }

    /**
     * @param mixed $file actual file
     * @return FileMatcher matcher responsible for file expectations handling.
     */
    public function file($file) {
        return $this->createExpectationMatcher(FileMatcher::class, $file);
    }

    /**
     * @param string $class matcher class. Class should implement {@link ExpectationMatcher} interface.
     * @param mixed $actualValue actual value being passed to matcher.
     * @return ExpectationMatcher matcher responsible for actual value expectations handling.
     */
    protected function createExpectationMatcher($class, $actualValue) {
        if (!empty($this->expectation) || !empty($this->scenario)) {
            $constructorArguments = [$actualValue, $this->scenario . $this->expectation];
            $this->expectation = '';
        } else {
            $constructorArguments = [$actualValue];
        }
        $matcherReflection = new \ReflectionClass($class);
        return $matcherReflection->newInstanceArgs($constructorArguments);
    }
}