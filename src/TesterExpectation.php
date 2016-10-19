<?php
namespace DeKey\Tester;

use DeKey\Tester\Contract\ExpectationMatcher;
use DeKey\Tester\Contract\UnitTestExpectation;
use DeKey\Tester\Matchers\ArrayMatcher;
use DeKey\Tester\Matchers\BooleanMatcher;
use DeKey\Tester\Matchers\ClassMatcher;
use DeKey\Tester\Matchers\DirectoryMatcher;
use DeKey\Tester\Matchers\FileMatcher;
use DeKey\Tester\Matchers\NumberMatcher;
use DeKey\Tester\Matchers\ObjectMatcher;
use DeKey\Tester\Matchers\StringMatcher;
use DeKey\Tester\Matchers\ValueMatcher;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Represents tester expectation. Contains a list of available matching methods and provides
 * access mechanism to call any available matcher.
 *
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class TesterExpectation implements UnitTestExpectation  {
    /**
     * @var TestCase test instance invoked expectation.
     */
    protected $test;
    /**
     * @var string expectation message that displays in error output if test fails.
     */
    protected $message;

    public function __construct(TestCase $test, $message = null) {
        $this->test = $test;
        $this->message = $message;
    }

    /**
     * @inheritdoc
     */
    public function valueOf($value) {
        return $this->createMatcher(ValueMatcher::class, $value);
    }

    /**
     * @inheritdoc
     */
    public function number($number) {
        return $this->createMatcher(NumberMatcher::class, $number);
    }

    /**
     * @inheritdoc
     */
    public function boolean($variable) {
        return $this->createMatcher(BooleanMatcher::class, $variable);
    }

    /**
     * @inheritdoc
     */
    public function string($variable) {
        return $this->createMatcher(StringMatcher::class, $variable);
    }

    /**
     * @inheritdoc
     */
    public function theArray($variable) {
        return $this->createMatcher(ArrayMatcher::class, $variable);
    }

    /**
     * @inheritdoc
     */
    public function object($object) {
        return $this->createMatcher(ObjectMatcher::class, $object);
    }

    /**
     * @inheritdoc
     */
    public function theClass($class) {
        return $this->createMatcher(ClassMatcher::class, $class);
    }

    /**
     * @inheritdoc
     */
    public function file($file) {
        return $this->createMatcher(FileMatcher::class, $file);
    }

    /**
     * @inheritdoc
     */
    public function directory($directory) {
        return $this->createMatcher(DirectoryMatcher::class, $directory);
    }

    /**
     * @inheritdoc
     */
    public function getTest() {
        return $this->test;
    }

    /**
     * @param string $matcherClass full class name of a matcher. Class should implement {@link ExpectationMatcher} interface.
     * @param mixed $actualValue actual value being passed to matcher.
     * @return ExpectationMatcher matcher responsible for actual value expectations handling.
     */
    protected function createMatcher($matcherClass, $actualValue) {
        if ($this->message) {
            $constructorArguments = [$this, $actualValue, $this->message];
        } else {
            $constructorArguments = [$this, $actualValue];
        }
        $matcherReflection = new \ReflectionClass($matcherClass);
        return $matcherReflection->newInstanceArgs($constructorArguments);
    }
}