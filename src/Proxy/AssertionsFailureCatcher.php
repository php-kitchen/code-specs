<?php

namespace DeKey\Tester\Proxy;

use DeKey\Tester\Base\ExpectationMatcher;

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
        $matcher = $this->matcher;
        if (method_exists($matcher, $name)) {
            $this->callMatcherMethod($name, $arguments);
        } else {
            $matcherClass = get_class($matcher);
            throw new \Exception($matcherClass . '::' . $name . ' does not exist!');
        }
        return $this->matcher;
    }

    protected function callMatcherMethod(&$name, &$arguments) {
        try {
            call_user_func_array([$this->matcher, $name], $arguments);
        } catch (\Exception $e) {
            $result = $this->test->getTestResultObject();
            $phpUnitFailedError = new \PHPUnit_Framework_AssertionFailedError($e->getMessage());
            $result->addFailure(clone $this->test, $phpUnitFailedError, $result->time());
        }
    }
}