<?php

namespace DeKey\Tester\Matchers\Internal;

use DeKey\Tester\Matchers\Base\Matcher;

/**
 * ExceptionMatcher is designed to check that object throws valid exception.
 * This matcher being used in pair with {@link ObjectMatcher}.
 *
 * @property \Exception $actual
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ObjectExceptionMatcher extends Matcher {
    public function withMessage($message) {
        $this->registerExpectation('has message "' . $message . '"');
        $this->test->expectExceptionMessage($message);
        return $this;
    }

    public function withMessageMatchesPattern($messagePattern) {
        $this->registerExpectation('has message matching pattern "' . $messagePattern . '"');
        $this->test->expectExceptionMessage($messagePattern);
        return $this;
    }

    public function withCode($code) {
        $this->registerExpectation('has code "' . $code . '"');
        $this->test->expectExceptionCode($code);
        return $this;
    }

    /**
     * Identifies a situation when exception should be raised.
     * Supposed to executes method of the object.
     * This methods should to be used after {@link throwsException} and "with*" methods to gain expression like:
     * <pre>
     * $I->seeThatObject($a)->throwsException(Exception::class)->when(function($object) {$object->doParty();});
     * // or
     * $I->seeThatObject($a)->throwsException(IronyException::class)->withCode(500)->when(function($object) {$object->doParty();});
     * <pre/>
     * and finish scenario.
     */
    public function when(callable $callback) {
        call_user_func_array($callback, [$this->actual]);
    }

    /**
     * Executes method of the object.
     * This methods supposed to be used after {@link throwsException} and "winf*" methods to gain expression like:
     * <pre>
     * $expectation->object($a)->throwsException(Exception::class)->whenInvokedMethod('class');
     * <pre/>
     * and finish scenario.
     *
     * @deprecated use {@link when}
     *
     * @param string $methodName name of thr object's method that should be invoked
     * @param array $methodArguments arguments that should be passed to method
     */
    public function whenInvokedMethod($methodName, $methodArguments = []) {
        call_user_func_array([$this->actual, $methodName], $methodArguments);
    }
}