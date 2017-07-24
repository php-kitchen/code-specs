<?php

namespace DeKey\Tester;

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
use DeKey\Tester\Specification\Tester;
use PHPUnit\Framework\Test;

/**
 * Represents tester expectation. Contains a list of available matching methods and provides
 * access mechanism to call any available matcher.
 *
 * @deprecated
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class TesterExpectation {
    /**
     * @var Tester actor who run the matcher
     */
    protected $actor;
    /**
     * @var \PHPUnit\Framework\TestCase test case matcher being used in
     */
    protected $test;
    /**
     * @var string expectation message that displays in error output if test fails.
     */
    protected $message;

    public function __construct(Tester $actor, Test $test, $message = null) {
        $this->actor = $actor;
        $this->test = $test;
        $this->message = $message;
    }

    /**
     * @inheritdoc
     */
    public function valueOf($value): ValueMatcher {
        return $this->createMatcher(ValueMatcher::class, $value);
    }

    /**
     * @inheritdoc
     */
    public function number($number): NumberMatcher {
        return $this->createMatcher(NumberMatcher::class, $number);
    }

    /**
     * @inheritdoc
     */
    public function boolean($variable): BooleanMatcher {
        return $this->createMatcher(BooleanMatcher::class, $variable);
    }

    /**
     * @inheritdoc
     */
    public function string($variable): StringMatcher {
        return $this->createMatcher(StringMatcher::class, $variable);
    }

    /**
     * @inheritdoc
     */
    public function theArray($variable): ArrayMatcher {
        return $this->createMatcher(ArrayMatcher::class, $variable);
    }

    /**
     * @inheritdoc
     */
    public function object($object): ObjectMatcher {
        return $this->createMatcher(ObjectMatcher::class, $object);
    }

    /**
     * @inheritdoc
     */
    public function theClass($class): ClassMatcher {
        return $this->createMatcher(ClassMatcher::class, $class);
    }

    /**
     * @inheritdoc
     */
    public function file($file): FileMatcher {
        return $this->createMatcher(FileMatcher::class, $file);
    }

    /**
     * @inheritdoc
     */
    public function directory($directory): DirectoryMatcher {
        return $this->createMatcher(DirectoryMatcher::class, $directory);
    }

    /**
     * @param string $matcherClass full class name of a matcher. Class should implement {@link ExpectationMatcher} interface.
     * @param mixed $actualValue actual value being passed to matcher.
     * @return ExpectationMatcher matcher responsible for actual value expectations handling.
     */
    protected function createMatcher($matcherClass, $actualValue) {
        if ($this->message) {
            $constructorArguments = [$this->actor, $this->test, $actualValue, $this->message];
        } else {
            $constructorArguments = [$this->actor, $this->test, $actualValue];
        }
        $matcherReflection = new \ReflectionClass($matcherClass);
        return $matcherReflection->newInstanceArgs($constructorArguments);
    }
}