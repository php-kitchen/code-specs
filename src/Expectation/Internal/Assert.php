<?php

namespace PHPKitchen\CodeSpecs\Expectation\Internal;

use ArrayAccess;
use PHPUnit\Framework\Test;

/**
 * Represents PHPUnit Assert facade.
 *
 * Goal of this class is prepare assert messages according
 *
 * @codeCoverageIgnore
 *
 * @package PHPKitchen\CodeSpecs\Expectation\Internal
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class Assert {
    const IN_TIME_EXECUTION_STRATEGY = 1;
    const DELAYED_EXECUTION_STRATEGY = 2;
    /**
     * @var mixed actual value or variable that will be matched to expectations.
     */
    protected $actual;
    /**
     * @var StepsList list of steps that was made prior current assert.
     */
    protected $stepsList;
    /**
     * @var Test the test object.
     */
    protected $test;
    /**
     * @var string description of expectation. If expectation fails this description will be displayed in console.
     */
    protected $description;
    /**
     * @var \SplQueue list of steps that was delayed to be executed after definition.
     */
    protected $delayedAssertSteps;
    /**
     * @var int execution strategy. Either {@link DELAYED_EXECUTION_STRATEGY} or {@link IN_TIME_EXECUTION_STRATEGY}.
     * Identifies whether to run assert methods when they called or later(runtime matchers functionality)
     */
    protected $strategy;
    /**
     * @var string internal value that identifies current step name that would be added to {@link stepsList}
     */
    private $currentStepName = '';

    public function __construct(StepsList $stepsList, Test $test, $actual, $description = '', $strategy = self::IN_TIME_EXECUTION_STRATEGY) {
        $this->stepsList = $stepsList;
        $this->test = $test;
        $this->actual = $actual;
        $this->description = $description;
        $this->delayedAssertSteps = new \SplQueue();
        $this->strategy = $strategy;
    }

    public function __clone() {
        $this->delayedAssertSteps = clone $this->delayedAssertSteps;
    }

    //region --------------------------- OWN METHODS ----------------------------//

    public function getActualValue() {
        return $this->actual;
    }

    public function changeDescriptionTo($newDescription) {
        $this->description = $newDescription;
    }

    public function changeCurrentStepTo($stepName) {
        $this->currentStepName = $stepName;
    }

    public function switchToInTimeExecutionStrategy() {
        $this->strategy = self::IN_TIME_EXECUTION_STRATEGY;
    }

    public function switchToDelayedExecutionStrategy() {
        $this->strategy = self::DELAYED_EXECUTION_STRATEGY;
    }

    public function runStepsWithActualValue($actualValue) {
        if ($this->strategy === self::DELAYED_EXECUTION_STRATEGY) {
            return;
        }
        $this->actual = $actualValue;
        while (!$this->delayedAssertSteps->isEmpty()) {
            $step = $this->delayedAssertSteps->dequeue();
            array_push($step[1], $this->getMessageForAssert());
            array_unshift($step[1], $this->actual);
            $this->executeAssertMethod($step[0], $step[1], $step[2]);
        }
    }

    protected function callAssertMethod($method, $config = []) {
        $stepName = $this->currentStepName;
        if ($this->strategy === self::IN_TIME_EXECUTION_STRATEGY) {
            $this->executeAssertMethod($method, $config, $stepName);
        } else {
            $this->delayedAssertSteps->enqueue([$method, $config, $stepName]);
        }
    }

    protected function executeAssertMethod($method, $config, $stepName) {
        $this->registerExpectation($stepName);
        if (is_callable([$this->test, $method])) {
            call_user_func_array([
                $this->test,
                $method,
            ], $this->buildAssertMethodParamsFromConfig($config));
        } elseif (method_exists($this, $method)) {
            call_user_func_array([
                $this,
                $method,
            ], $this->buildAssertMethodParamsFromConfig($config));
        } else {
            throw new \InvalidArgumentException("Assert method '{$method}' does not exist");
        }
    }

    protected function buildAssertMethodParamsFromConfig($config) {
        $params = [];
        if (array_key_exists('expected', $config)) {
            $params[] = $config['expected'];
        }
        $params[] = $this->actual;
        if (isset($config['options'])) {
            $params = array_merge($params, $config['options']);
        }

        $params[] = $this->getMessageForAssert();

        if (isset($config['additionalParams'])) {
            $params = array_merge($params, $config['additionalParams']);
        }

        return $params;
    }

    protected function registerExpectation($message) {
        $this->stepsList->add("$this->description {$message}.");
    }

    protected function getMessageForAssert() {
        return $this->stepsList->convertToString();
    }

    //endregion

    /**
     * @param string $exception
     */
    public function expectException($exception) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $exception,
        ]);
    }

    /**
     * @param string $exception
     */
    public function expectExceptionObject($exceptionObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $exceptionObject,
        ]);
    }

    /**
     * @param int|string $code
     *
     * @throws \Exception
     */
    public function expectExceptionCode($code) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $code,
        ]);
    }

    /**
     * @param string $message
     *
     * @throws \Exception
     */
    public function expectExceptionMessage($message) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $message,
        ]);
    }

    /**
     * @param string $messageRegExp
     *
     * @throws \Exception
     */
    public function expectExceptionMessageRegExp($messageRegExp) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $messageRegExp,
        ]);
    }

    /**
     * Asserts that an array has a specified key.
     *
     * @param mixed $key
     */
    public function assertArrayHasKey($key) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that an array has a specified subset.
     *
     * @param array|ArrayAccess $subset
     */
    public function assertArraySubset($subset, $useStrictMatch) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $subset,
            'options' => [
                $useStrictMatch,
            ],
        ]);
    }

    /**
     * Asserts that an array does not have a specified key.
     *
     * @param mixed $key
     * @param array|ArrayAccess $array
     * @param string $message
     */
    public function assertArrayNotHasKey($key) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a haystack contains a needle.
     *
     * @param mixed $needle
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     */
    public function assertContains($needle, $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
            'additionalParams' => [
                $ignoreCase,
                $checkForObjectIdentity,
                $checkForNonObjectIdentity,
            ],
        ]);
    }

    /**
     * Asserts that a haystack does not contain a needle.
     *
     * @param mixed $needle
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     */
    public function assertNotContains($needle, $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
            'additionalParams' => [
                $ignoreCase,
                $checkForObjectIdentity,
                $checkForNonObjectIdentity,
            ],
        ]);
    }

    /**
     * Asserts that a haystack contains only values of a given type.
     *
     * @param string $type
     * @param bool $isNativeType
     */
    public function assertContainsOnly($type, $isNativeType = null) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $type,
            'options' => [
                $isNativeType,
            ],
        ]);
    }

    /**
     * Asserts that a haystack does not contain only values of a given type.
     *
     * @param string $type
     * @param bool $isNativeType
     */
    public function assertNotContainsOnly($type, $isNativeType = null) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $type,
            'options' => [
                $isNativeType,
            ],
        ]);
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains a needle.
     *
     * @param mixed $needle
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     */
    public function assertAttributeContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain a needle.
     *
     * @param mixed $needle
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     */
    public function assertAttributeNotContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a haystack contains only instances of a given classname
     *
     * @param string $className
     */
    public function assertContainsOnlyInstancesOf($className) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $className,
        ]);
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains only values of a given type.
     *
     * @param string $type
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param bool $isNativeType
     * @param string $message
     */
    public function assertAttributeContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = null) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain only values of a given
     * type.
     *
     * @param string $type
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param bool $isNativeType
     * @param string $message
     */
    public function assertAttributeNotContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = null) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts the number of elements of an array, \Countable or \Traversable.
     *
     * @param int $expectedCount
     */
    public function assertCount($expectedCount) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedCount,
        ]);
    }

    /**
     * Asserts the number of elements of an array, \Countable or \Traversable
     * that is stored in an attribute.
     *
     * @param int $expectedCount
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param string $message
     */
    public function assertAttributeCount($expectedCount, $haystackAttributeName, $haystackClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts the number of elements of an array, \Countable or \Traversable.
     *
     * @param int $expectedCount
     * @param mixed $haystack
     * @param string $message
     */
    public function assertNotCount($expectedCount) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedCount,
        ]);
    }

    /**
     * Asserts the number of elements of an array, \Countable or \Traversable
     * that is stored in an attribute.
     *
     * @param int $expectedCount
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param string $message
     */
    public function assertAttributeNotCount($expectedCount, $haystackAttributeName, $haystackClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that two variables are equal.
     *
     * @param mixed $expected
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertEquals($expected, $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
            'additionalParams' => [
                $delta,
                $maxDepth,
                $canonicalize,
                $ignoreCase,
            ],
        ]);
    }

    /**
     * Asserts that a variable is equal to an attribute of an object.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertAttributeEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that two variables are not equal.
     *
     * @param mixed $expected
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertNotEquals($expected, $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
            'additionalParams' => [
                $delta,
                $maxDepth,
                $canonicalize,
                $ignoreCase,
            ],
        ]);
    }

    /**
     * Asserts that a variable is not equal to an attribute of an object.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertAttributeNotEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a variable is empty.
     *
     *
     * @throws AssertionFailedError
     */
    public function assertEmpty() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is empty.
     *
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param string $message
     */
    public function assertAttributeEmpty($haystackAttributeName, $haystackClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a variable is not empty.
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws AssertionFailedError
     */
    public function assertNotEmpty() {
        $this->callAssertMethod(__FUNCTION__, []);
    }

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is not empty.
     *
     * @param string $haystackAttributeName
     * @param string|object $haystackClassOrObject
     * @param string $message
     */
    public function assertAttributeNotEmpty($haystackAttributeName, $haystackClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a value is greater than another value.
     *
     * @param mixed $expected
     */
    public function assertGreaterThan($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is greater than another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     */
    public function assertAttributeGreaterThan($expected, $actualAttributeName, $actualClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a value is greater than or equal to another value.
     *
     * @param mixed $expected
     */
    public function assertGreaterThanOrEqual($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is greater than or equal to another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     */
    public function assertAttributeGreaterThanOrEqual($expected, $actualAttributeName, $actualClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a value is smaller than another value.
     *
     * @param mixed $expected
     */
    public function assertLessThan($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is smaller than another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     */
    public function assertAttributeLessThan($expected, $actualAttributeName, $actualClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a value is smaller than or equal to another value.
     *
     * @param mixed $expected
     */
    public function assertLessThanOrEqual($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is smaller than or equal to another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     */
    public function assertAttributeLessThanOrEqual($expected, $actualAttributeName, $actualClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file.
     *
     * @param string $expected
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertFileEquals($expected, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
            'additionalParams' => [
                $canonicalize,
                $ignoreCase,
            ],
        ]);
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of
     * another file.
     *
     * @param string $expected
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertFileNotEquals($expected, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
            'additionalParams' => [
                $canonicalize,
                $ignoreCase,
            ],
        ]);
    }

    /**
     * Asserts that the contents of a string is equal
     * to the contents of a file.
     *
     * @param string $expectedFile
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertStringEqualsFile($expectedFile, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
            'additionalParams' => [
                $canonicalize,
                $ignoreCase,
            ],
        ]);
    }

    /**
     * Asserts that the contents of a string is not equal
     * to the contents of a file.
     *
     * @param string $expectedFile
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    public function assertStringNotEqualsFile($expectedFile, $canonicalize = false, $ignoreCase = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
            'additionalParams' => [
                $canonicalize,
                $ignoreCase,
            ],
        ]);
    }

    /**
     * Asserts that a file/dir is readable.
     */
    public function assertIsReadable() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file/dir exists and is not readable.
     */
    public function assertNotIsReadable() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file/dir exists and is writable.
     */
    public function assertIsWritable() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file/dir exists and is not writable.
     */
    public function assertNotIsWritable() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory exists.
     */
    public function assertDirectoryExists() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory does not exist.
     */
    public function assertDirectoryNotExists() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory exists and is readable.
     *
     * @param string $directory
     * @param string $message
     */
    public function assertDirectoryIsReadable($directory) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a directory exists and is not readable.
     *
     * @param string $directory
     * @param string $message
     */
    public function assertDirectoryNotIsReadable($directory) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a directory exists and is writable.
     *
     * @param string $directory
     * @param string $message
     */
    public function assertDirectoryIsWritable($directory) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a directory exists and is not writable.
     *
     * @param string $directory
     * @param string $message
     */
    public function assertDirectoryNotIsWritable($directory) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a file exists.
     */
    public function assertFileExists() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file does not exist.
     */
    public function assertFileNotExists() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file exists and is readable.
     *
     * @param string $file
     * @param string $message
     */
    public function assertFileIsReadable($file) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a file exists and is not readable.
     *
     * @param string $file
     * @param string $message
     */
    public function assertFileNotIsReadable($file) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a file exists and is writable.
     *
     * @param string $file
     * @param string $message
     */
    public function assertFileIsWritable($file) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a file exists and is not writable.
     */
    public function assertFileNotIsWritable() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is true.
     *
     * @throws AssertionFailedError
     */
    public function assertTrue() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is not true.
     *
     * @throws AssertionFailedError
     */
    public function assertNotTrue() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is false.
     *
     * @throws AssertionFailedError
     */
    public function assertFalse() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is not false
     *
     * @throws AssertionFailedError
     */
    public function assertNotFalse() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is null.
     *
     * @param mixed $actual
     */
    public function assertNull() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not null.
     */
    public function assertNotNull() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is finite.
     */
    public function assertFinite() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is infinite.
     */
    public function assertInfinite() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is nan.
     */
    public function assertNan() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a class exists
     */
    public function assertClassExists() {
        $this->callAssertMethod('classExists');
    }

    protected function classExists($class, $message) {
        $this->test->assertTrue(class_exists($class), $message);
    }

    /**
     * Asserts that a class does not exist
     */
    public function assertClassDoesNotExist() {
        $this->callAssertMethod('classDoesNotExist');
    }

    protected function classDoesNotExist($class, $message) {
        $this->test->assertFalse(class_exists($class), $message);
    }

    /**
     * Asserts that a class does not exist
     */
    public function assertClassIsInterface() {
        $this->callAssertMethod('classIsInterface');
    }

    protected function classIsInterface($class, $message) {
        $this->test->assertTrue(interface_exists($class), $message);
    }

    /**
     * Asserts that a class does not exist
     */
    public function assertClassIsNotInterface() {
        $this->callAssertMethod('classIsNotInterface');
    }

    protected function classIsNotInterface($class, $message) {
        $this->test->assertFalse(interface_exists($class), $message);
    }

    /**
     * Asserts that a class has a specified attribute.
     *
     * @param string $attributeName
     */
    public function assertClassHasAttribute($attributeName) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that a class does not have a specified attribute.
     *
     * @param string $attributeName
     */
    public function assertClassNotHasAttribute($attributeName) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that a class has a specified static attribute.
     *
     * @param string $attributeName
     */
    public function assertClassHasStaticAttribute($attributeName) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that a class does not have a specified static attribute.
     *
     * @param string $attributeName
     */
    public function assertClassNotHasStaticAttribute($attributeName) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that an object has a specified attribute.
     *
     * @param string $attributeName
     */
    public function assertObjectHasAttribute($attributeName) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that an object does not have a specified attribute.
     *
     * @param string $attributeName
     */
    public function assertObjectNotHasAttribute($attributeName) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that two variables have the same type and value.
     * Used on objects, it asserts that two variables reference
     * the same object.
     *
     * @param mixed $expected
     */
    public function assertSame($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a variable and an attribute of an object have the same type
     * and value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     */
    public function assertAttributeSame($expected, $actualAttributeName, $actualClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that two variables do not have the same type and value.
     * Used on objects, it asserts that two variables do not reference
     * the same object.
     *
     * @param mixed $expected
     */
    public function assertNotSame($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a variable and an attribute of an object do not have the
     * same type and value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string|object $actualClassOrObject
     * @param string $message
     */
    public function assertAttributeNotSame($expected, $actualAttributeName, $actualClassOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a variable is of a given type.
     *
     * @param string $expected
     */
    public function assertInstanceOf($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param string|object $classOrObject
     * @param string $message
     */
    public function assertAttributeInstanceOf($expected, $attributeName, $classOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a variable is not of a given type.
     *
     * @param string $expected
     */
    public function assertNotInstanceOf($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param string|object $classOrObject
     * @param string $message
     */
    public function assertAttributeNotInstanceOf($expected, $attributeName, $classOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a variable is of a given type.
     *
     * @param string $expected
     */
    public function assertInternalType($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param string|object $classOrObject
     * @param string $message
     */
    public function assertAttributeInternalType($expected, $attributeName, $classOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a variable is not of a given type.
     *
     * @param string $expected
     */
    public function assertNotInternalType($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param string|object $classOrObject
     * @param string $message
     */
    public function assertAttributeNotInternalType($expected, $attributeName, $classOrObject) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a string matches a given regular expression.
     *
     * @param string $pattern
     */
    public function assertRegExp($pattern) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $pattern,
        ]);
    }

    /**
     * Asserts that a string does not match a given regular expression.
     *
     * @param string $pattern
     */
    public function assertNotRegExp($pattern, $string) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Assert that the size of two arrays (or `\Countable` or `\Traversable` objects)
     * is the same.
     *
     * @param array|\Countable|\Traversable $expected
     */
    public function assertSameSize($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Assert that the size of two arrays (or `\Countable` or `\Traversable` objects)
     * is not the same.
     *
     * @param array|\Countable|\Traversable $expected
     * @param array|\Countable|\Traversable $actual
     * @param string $message
     */
    public function assertNotSameSize($expected) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a string matches a given format string.
     *
     * @param string $format
     */
    public function assertStringMatchesFormat($format) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $format,
        ]);
    }

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $format
     */
    public function assertStringNotMatchesFormat($format) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $format,
        ]);
    }

    /**
     * Asserts that a string matches a given format file.
     *
     * @param string $formatFile
     */
    public function assertStringMatchesFormatFile($formatFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $formatFile,
        ]);
    }

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $formatFile
     */
    public function assertStringNotMatchesFormatFile($formatFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $formatFile,
        ]);
    }

    /**
     * Asserts that a string starts with a given prefix.
     *
     * @param string $prefix
     */
    public function assertStringStartsWith($prefix) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $prefix,
        ]);
    }

    /**
     * Asserts that a string starts not with a given prefix.
     *
     * @param string $prefix
     */
    public function assertStringStartsNotWith($prefix) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $prefix,
        ]);
    }

    /**
     * Asserts that a string ends with a given suffix.
     *
     * @param string $suffix
     */
    public function assertStringEndsWith($suffix) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $suffix,
        ]);
    }

    /**
     * Asserts that a string ends not with a given suffix.
     *
     * @param string $suffix
     * @param string $string
     * @param string $message
     */
    public function assertStringEndsNotWith($suffix) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $suffix,
        ]);
    }

    /**
     * Asserts that two XML files are equal.
     *
     * @param string $expectedFile
     */
    public function assertXmlFileEqualsXmlFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML files are not equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     */
    public function assertXmlFileNotEqualsXmlFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string $expectedFile
     */
    public function assertXmlStringEqualsXmlFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string $expectedFile
     */
    public function assertXmlStringNotEqualsXmlFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string|\DOMDocument $expectedXml
     * @param string $message
     */
    public function assertXmlStringEqualsXmlString($expectedXml) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedXml,
        ]);
    }

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string|\DOMDocument $expectedXml
     */
    public function assertXmlStringNotEqualsXmlString($expectedXml) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedXml,
        ]);
    }

    /**
     * Asserts that a hierarchy of DOMElements matches.
     *
     * @param \DOMElement $expectedElement
     * @param bool $checkAttributes
     */
    public function assertEqualXMLStructure(\DOMElement $expectedElement, $checkAttributes = false) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedElement,
            'options' => [
                $checkAttributes,
            ],
        ]);
    }

    /**
     * Asserts that a string is a valid JSON string.
     */
    public function assertJson() {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that two given JSON encoded objects or arrays are equal.
     *
     * @param string $expectedJson
     */
    public function assertJsonStringEqualsJsonString($expectedJson) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedJson,
        ]);
    }

    /**
     * Asserts that two given JSON encoded objects or arrays are not equal.
     *
     * @param string $expectedJson
     */
    public function assertJsonStringNotEqualsJsonString($expectedJson) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedJson,
        ]);
    }

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are equal.
     *
     * @param string $expectedFile
     */
    public function assertJsonStringEqualsJsonFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are not equal.
     *
     * @param string $expectedFile
     */
    public function assertJsonStringNotEqualsJsonFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two JSON files are equal.
     *
     * @param string $expectedFile
     */
    public function assertJsonFileEqualsJsonFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two JSON files are not equal.
     *
     * @param string $expectedFile
     */
    public function assertJsonFileNotEqualsJsonFile($expectedFile) {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }
}