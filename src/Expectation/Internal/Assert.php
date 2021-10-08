<?php

namespace PHPKitchen\CodeSpecs\Expectation\Internal;

use ArrayAccess;
use Countable;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use DOMDocument;
use DOMElement;
use Exception;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use SplQueue;
use Traversable;

/**
 * Represents PHPUnit Assert facade.
 *
 * Goal of this class is prepare assert messages according
 *
 * @codeCoverageIgnore
 *
 * @package PHPKitchen\CodeSpecs\Expectation\Internal
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class Assert {
    use ArraySubsetAsserts {
        ArraySubsetAsserts::assertArraySubset as assertArraySubsetDMS;
    }

    protected const IN_TIME_EXECUTION_STRATEGY = 1;
    protected const DELAYED_EXECUTION_STRATEGY = 2;
    /**
     * @var mixed actual value or variable that will be matched to expectations.
     */
    protected $actual;
    /**
     * @var StepsList list of steps that was made prior current assert.
     */
    protected $stepsList;
    /**
     * @var string description of expectation. If expectation fails this description will be displayed in console.
     */
    protected $description;
    /**
     * @var SplQueue list of steps that was delayed to be executed after definition.
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

    public function __construct(StepsList $stepsList, $actual, $description = '', $strategy = self::IN_TIME_EXECUTION_STRATEGY) {
        $this->stepsList = $stepsList;
        $this->actual = $actual;
        $this->description = $description;
        $this->delayedAssertSteps = new SplQueue();
        $this->strategy = $strategy;
    }

    public function __clone() {
        $this->delayedAssertSteps = clone $this->delayedAssertSteps;
    }

    //region --------------------------- OWN METHODS ----------------------------//

    public function getActualValue() {
        return $this->actual;
    }

    public function changeDescriptionTo(string $newDescription): void {
        $this->description = $newDescription;
    }

    public function changeCurrentStepTo(string $stepName): void {
        $this->currentStepName = $stepName;
    }

    public function switchToInTimeExecutionStrategy(): void {
        $this->strategy = self::IN_TIME_EXECUTION_STRATEGY;
    }

    public function switchToDelayedExecutionStrategy(): void {
        $this->strategy = self::DELAYED_EXECUTION_STRATEGY;
    }

    public function runStepsWithActualValue($actualValue): void {
        if ($this->strategy === self::DELAYED_EXECUTION_STRATEGY) {
            return;
        }
        $this->actual = $actualValue;
        while (!$this->delayedAssertSteps->isEmpty()) {
            $step = $this->delayedAssertSteps->dequeue();
            $step[1][] = $this->getMessageForAssert();
            array_unshift($step[1], $this->actual);
            $this->executeAssertMethod($step[0], $step[1], $step[2]);
        }
    }

    protected function callAssertMethod(string $method, array $config = []): void {
        $stepName = $this->currentStepName;
        if ($this->strategy === self::IN_TIME_EXECUTION_STRATEGY) {
            $this->executeAssertMethod($method, $config, $stepName);
        } else {
            $this->delayedAssertSteps->enqueue([$method, $config, $stepName]);
        }
    }

    protected function executeAssertMethod(string $method, array $config, string $stepName): void {
        $this->registerExpectation($stepName);
        if (is_callable([\PHPUnit\Framework\Assert::class, $method])) {
            call_user_func_array([
                \PHPUnit\Framework\Assert::class,
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

    protected function buildAssertMethodParamsFromConfig(array $config): array {
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

    protected function registerExpectation(string $message): void {
        $this->stepsList->add("$this->description {$message}.");
    }

    protected function getMessageForAssert(): string {
        return $this->stepsList->convertToString();
    }

    //endregion

    /**
     * @param string $exception
     */
    public function expectException(string $exception): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $exception,
        ]);
    }

    /**
     * @param object $exceptionObject
     */
    public function expectExceptionObject($exceptionObject): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $exceptionObject,
        ]);
    }

    /**
     * @param int|string $code
     *
     * @throws Exception
     */
    public function expectExceptionCode($code): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $code,
        ]);
    }

    /**
     * @param string $message
     *
     * @throws Exception
     */
    public function expectExceptionMessage(string $message): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $message,
        ]);
    }

    /**
     * @param string $messageRegExp
     *
     * @throws Exception
     */
    public function expectExceptionMessageRegExp(string $messageRegExp): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $messageRegExp,
        ]);
    }

    /**
     * Asserts that an array has a specified key.
     *
     * @param mixed $key
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertArrayHasKey($key): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that an array has a specified subset.
     * Deprecated at PhpUnit https://github.com/sebastianbergmann/phpunit/issues/3494
     * Can use only with https://github.com/rdohms/phpunit-arraysubset-asserts
     *
     * @param array|ArrayAccess $subset
     * @param bool $checkForObjectIdentity
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertArraySubset($subset, bool $checkForObjectIdentity): void {
        $this->callAssertMethod('assertArraySubsetDMS', [
            'expected' => $subset,
            'options' => [
                $checkForObjectIdentity,
            ],
        ]);
    }

    /**
     * Asserts that an array does not have a specified key.
     *
     * @param mixed $key
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertArrayNotHasKey($key): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $key,
        ]);
    }

    /**
     * Asserts that a haystack contains a needle.
     *
     * @param mixed $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertContains($needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * Asserts that a haystack contains a needle.
     *
     * @param mixed $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertContainsEquals($needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * Asserts that a haystack does not contain a needle.
     *
     * @param mixed $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotContains($needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * Asserts that a haystack not contains a needle.
     *
     * @param $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotContainsEquals($needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * Asserts that a haystack contains only values of a given type.
     *
     * @param string $type
     * @param bool $isNativeType
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertContainsOnly(string $type, ?bool $isNativeType = null): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $type,
            'options' => [
                $isNativeType,
            ],
        ]);
    }

    /**
     * Asserts that a haystack contains only instances of a given classname
     *
     * @param string $className
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertContainsOnlyInstancesOf(string $className): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $className,
        ]);
    }

    /**
     * Asserts that a haystack does not contain only values of a given type.
     *
     * @param string $type
     * @param bool $isNativeType
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotContainsOnly(string $type, ?bool $isNativeType = null): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $type,
            'options' => [
                $isNativeType,
            ],
        ]);
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param int $expectedCount
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertCount(int $expectedCount): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedCount,
        ]);
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param int $expectedCount
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotCount(int $expectedCount): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedCount,
        ]);
    }

    /**
     * Asserts that two variables are equal.
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertEquals($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that two variables are equal (canonicalizing).
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertEqualsCanonicalizing($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that two variables are equal (ignoring case).
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertEqualsIgnoringCase($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that two variables are equal (with delta).
     *
     * @param mixed $expected
     * @param float $delta
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertEqualsWithDelta($expected, float $delta): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
            'options' => [
                $delta,
            ],
        ]);
    }

    /**
     * Asserts that two variables are not equal.
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotEquals($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that two variables are not equal (canonicalizing).
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotEqualsCanonicalizing($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that two variables are not equal (ignoring case).
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotEqualsIgnoringCase($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that two variables are not equal (with delta).
     *
     * @param mixed $expected
     * @param float $delta
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotEqualsWithDelta($expected, float $delta): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
            'options' => [
                $delta,
            ],
        ]);
    }

    /**
     * Asserts that a variable is empty.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertEmpty(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not empty.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotEmpty(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a value is greater than another value.
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertGreaterThan($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a value is greater than or equal to another value.
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertGreaterThanOrEqual($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a value is smaller than another value.
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertLessThan($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a value is smaller than or equal to another value.
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertLessThanOrEqual($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another file.
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileEquals(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file (canonicalizing).
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileEqualsCanonicalizing(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file (ignoring case).
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileEqualsIgnoringCase(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of another file.
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileNotEquals(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of another
     * file (canonicalizing).
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileNotEqualsCanonicalizing(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of another
     * file (ignoring case).
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileNotEqualsIgnoringCase(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that the contents of a string is equal to the contents of a file.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringEqualsFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that the contents of a string is equal to the contents of a file (canonicalizing).
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringEqualsFileCanonicalizing(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that the contents of a string is equal to the contents of a file (ignoring case).
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringEqualsFileIgnoringCase(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that the contents of a string is not equal to the contents of a file.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringNotEqualsFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that the contents of a string is not equal to the contents of a file (canonicalizing).
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringNotEqualsFileCanonicalizing(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that the contents of a string is not equal to the contents of a file (ignoring case).
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringNotEqualsFileIgnoringCase(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that a file/dir is readable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsReadable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file/dir exists and is not readable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotReadable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file/dir exists and is writable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsWritable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file/dir exists and is not writable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotWritable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory exists.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertDirectoryExists(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory does not exist.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertDirectoryDoesNotExist(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory exists and is readable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertDirectoryIsReadable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory exists and is not readable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertDirectoryIsNotReadable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory exists and is writable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertDirectoryIsWritable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a directory exists and is not writable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertDirectoryIsNotWritable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file exists.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileExists(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file does not exist.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileDoesNotExist(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file exists and is readable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileIsReadable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file exists and is not readable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileIsNotReadable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file exists and is writable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileIsWritable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a file exists and is not writable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFileIsNotWritable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is true.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertTrue(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is not true.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotTrue(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is false.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFalse(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a condition is not false
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotFalse(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is null.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNull(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not null.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotNull(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is finite.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertFinite(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is infinite.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertInfinite(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is nan.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNan(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a class exists
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertClassExists(): void {
        $this->callAssertMethod('classExists');
    }

    protected function classExists($class, $message): void {
        \PHPUnit\Framework\Assert::assertTrue(class_exists($class), $message);
    }

    /**
     * Asserts that a class does not exist
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertClassDoesNotExist(): void {
        $this->callAssertMethod('classDoesNotExist');
    }

    protected function classDoesNotExist($class, $message): void {
        \PHPUnit\Framework\Assert::assertFalse(class_exists($class), $message);
    }

    /**
     * Asserts that a class does not exist
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertClassIsInterface(): void {
        $this->callAssertMethod('classIsInterface');
    }

    protected function classIsInterface($class, $message): void {
        \PHPUnit\Framework\Assert::assertTrue(interface_exists($class), $message);
    }

    /**
     * Asserts that a class does not exist
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertClassIsNotInterface(): void {
        $this->callAssertMethod('classIsNotInterface');
    }

    protected function classIsNotInterface($class, $message): void {
        \PHPUnit\Framework\Assert::assertFalse(interface_exists($class), $message);
    }

    /**
     * Asserts that a class has a specified attribute.
     *
     * @param string $attributeName
     */
    public function assertClassHasAttribute(string $attributeName): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that a class does not have a specified attribute.
     *
     * @param string $attributeName
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertClassNotHasAttribute(string $attributeName): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that a class has a specified static attribute.
     *
     * @param string $attributeName
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertClassHasStaticAttribute(string $attributeName): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that a class does not have a specified static attribute.
     *
     * @param string $attributeName
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertClassNotHasStaticAttribute(string $attributeName): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that an object has a specified attribute.
     *
     * @param string $attributeName
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertObjectHasAttribute(string $attributeName): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $attributeName,
        ]);
    }

    /**
     * Asserts that an object does not have a specified attribute.
     *
     * @param string $attributeName
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertObjectNotHasAttribute(string $attributeName): void {
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
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertSame($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that two variables do not have the same type and value.
     * Used on objects, it asserts that two variables do not reference
     * the same object.
     *
     * @param mixed $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotSame($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a variable is of a given type.
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertInstanceOf(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a variable is not of a given type.
     *
     * @param string $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotInstanceOf(string $expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a variable is of type array.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsArray(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type bool.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsBool(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type float.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsFloat(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type int.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsInt(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type numeric.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNumeric(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type object.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsObject(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type resource.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsResource(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type resource and is closed.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsClosedResource(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type string.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsString(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type scalar.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsScalar(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type callable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsCallable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is of type iterable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsIterable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type array.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotArray(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type bool.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotBool(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type float.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotFloat(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type int.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotInt(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type numeric.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotNumeric(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type object.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotObject(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type resource.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotResource(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type resource.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotClosedResource(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type string.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotString(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type scalar.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotScalar(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type callable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotCallable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a variable is not of type iterable.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertIsNotIterable(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that a string matches a given regular expression.
     *
     * @param string $pattern
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertRegExp(string $pattern): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $pattern,
        ]);
    }

    /**
     * Asserts that a string does not match a given regular expression.
     *
     * @param string $pattern
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertDoesNotMatchRegularExpression(string $pattern): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $pattern,
        ]);
    }

    /**
     * Assert that the size of two arrays (or `\Countable` or `\Traversable` objects)
     * is the same.
     *
     * @param array|Countable|Traversable $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertSameSize($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Assert that the size of two arrays (or `\Countable` or `\Traversable` objects)
     * is not the same.
     *
     * @param array|Countable|Traversable $expected
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertNotSameSize($expected): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expected,
        ]);
    }

    /**
     * Asserts that a string matches a given format string.
     *
     * @param string $format
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringMatchesFormat(string $format): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $format,
        ]);
    }

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $format
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringNotMatchesFormat(string $format): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $format,
        ]);
    }

    /**
     * Asserts that a string matches a given format file.
     *
     * @param string $formatFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringMatchesFormatFile(string $formatFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $formatFile,
        ]);
    }

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $formatFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringNotMatchesFormatFile(string $formatFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $formatFile,
        ]);
    }

    /**
     * Asserts that a string starts with a given prefix.
     *
     * @param string $prefix
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringStartsWith(string $prefix): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $prefix,
        ]);
    }

    /**
     * Asserts that a string starts not with a given prefix.
     *
     * @param string $prefix
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringStartsNotWith(string $prefix): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $prefix,
        ]);
    }

    /**
     * @param string $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringContainsString(string $needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * @param string $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringContainsStringIgnoringCase(string $needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * @param string $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringNotContainsString(string $needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * @param string $needle
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringNotContainsStringIgnoringCase(string $needle): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $needle,
        ]);
    }

    /**
     * Asserts that a string ends with a given suffix.
     *
     * @param string $suffix
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringEndsWith(string $suffix): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $suffix,
        ]);
    }

    /**
     * Asserts that a string ends not with a given suffix.
     *
     * @param string $suffix
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertStringEndsNotWith(string $suffix): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $suffix,
        ]);
    }

    /**
     * Asserts that two XML files are equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertXmlFileEqualsXmlFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML files are not equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertXmlFileNotEqualsXmlFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertXmlStringEqualsXmlFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertXmlStringNotEqualsXmlFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string|DOMDocument $expectedXml
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertXmlStringEqualsXmlString($expectedXml): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedXml,
        ]);
    }

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string|DOMDocument $expectedXml
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertXmlStringNotEqualsXmlString($expectedXml): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedXml,
        ]);
    }

    /**
     * Asserts that a hierarchy of DOMElements matches.
     *
     * @param DOMElement $expectedElement
     * @param bool $checkAttributes
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertEqualXMLStructure(DOMElement $expectedElement, $checkAttributes = false): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedElement,
            'options' => [
                $checkAttributes,
            ],
        ]);
    }

    /**
     * Asserts that a string is a valid JSON string.
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertJson(): void {
        $this->callAssertMethod(__FUNCTION__);
    }

    /**
     * Asserts that two given JSON encoded objects or arrays are equal.
     *
     * @param string $expectedJson
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertJsonStringEqualsJsonString(string $expectedJson): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedJson,
        ]);
    }

    /**
     * Asserts that two given JSON encoded objects or arrays are not equal.
     *
     * @param string $expectedJson
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertJsonStringNotEqualsJsonString(string $expectedJson): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedJson,
        ]);
    }

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertJsonStringEqualsJsonFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are not equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertJsonStringNotEqualsJsonFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two JSON files are equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertJsonFileEqualsJsonFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }

    /**
     * Asserts that two JSON files are not equal.
     *
     * @param string $expectedFile
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function assertJsonFileNotEqualsJsonFile(string $expectedFile): void {
        $this->callAssertMethod(__FUNCTION__, [
            'expected' => $expectedFile,
        ]);
    }
}
