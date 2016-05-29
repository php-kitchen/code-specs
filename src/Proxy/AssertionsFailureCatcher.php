<?php

namespace DeKey\Tester\Proxy;

use DeKey\Tester\Base\ExpectationMatcher;
use RuntimeException;

/**
 * AssertionsFailureCatcher is a proxy for expectation matcher that handles errors thrown by PHPUnit
 * Assert to process errors and provide correct console output because specifications set in {@link UnitTester}
 * breaks default output format that usually being parsed by IDE's or CI tools.
 *
 * @package DeKey\Tester\Proxy
 * @author Dmitry Kolodko
 */
class AssertionsFailureCatcher {
    /**
     * @var \PHPUnit_Framework_TestCase test case matcher being used in.
     */
    protected $test;
    protected $matcher;

    public function __construct(\PHPUnit_Framework_TestCase $test, ExpectationMatcher $matcher) {
        $this->test = $test;
        $this->matcher = $matcher;
    }

    public function __call($name, $arguments) {
        return $this->proxyMethodCallToMatcher($name, $arguments);
    }

    protected function proxyMethodCallToMatcher(&$name, &$arguments) {
        $matcher = $this->matcher;
        if (method_exists($matcher, $name)) {
            $result = $this->executeMethodIfPublic($name, $arguments);
        } else {
            $matcherClass = get_class($matcher);
            $this->throwExceptionWithMessage($matcherClass . '::' . $name . ' does not exist!');
        }

        return $result;
    }

    protected function executeMethodIfPublic(&$name, &$arguments) {
        $matcher = $this->matcher;
        $matcherClass = get_class($matcher);
        $reflection = new \ReflectionMethod($this->matcher, $name);
        if (!$reflection->isPublic()) {
            $this->throwExceptionWithMessage("Trying to access not public method {$name} of {$matcherClass}");
        }
        return $this->callMatcherMethod($name, $arguments);
    }

    protected function throwExceptionWithMessage($message) {
        throw new RuntimeException($message);
    }

    protected function callMatcherMethod(&$name, &$arguments) {
        try {
            $result = call_user_func_array([$this->matcher, $name], $arguments);
        } catch (\Exception $e) {
            $result = $this->addFailureException($e);
        }
        return $result;
    }

    protected function addFailureException(\Exception $e) {
        $testResult = $this->test->getTestResultObject();
        $phpUnitFailedError = new \PHPUnit_Framework_AssertionFailedError($e->getMessage());
        $testResult->addFailure(clone $this->test, $phpUnitFailedError, $testResult->time());
        return $this->matcher;
    }
}