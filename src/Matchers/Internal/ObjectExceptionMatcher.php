<?php

namespace DeKey\Tester\Matchers\Internal;

use DeKey\Tester\Base\Matcher;

/**
 * ExceptionMatcher is designed to check that object throws valid exception.
 * This matcher being used in pair with {@link ObjectMatcher}.
 *
 * @property \Exception $actual
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class ObjectExceptionMatcher extends Matcher {
    public function withMessage($message) {
        $this->expectation->getTest()->expectExceptionMessage($message);
        return $this;
    }

    public function withMessageMatchesPattern($messagePattern) {
        $this->expectation->getTest()->expectExceptionMessage($messagePattern);
        return $this;
    }

    public function withCode($code) {
        $this->expectation->getTest()->expectExceptionCode($code);
        return $this;
    }

    /**
     * Executes method of the object.
     * This methods supposed to be used after {@link throwsException} and "winf*" methods to gain expression like:
     * <pre>
     * $expectation->object($a)->throwsException(Exception::class)->whenInvokedMethod('class');
     * <pre/>
     * and finish scenario.
     *
     * @param string $methodName name of thr object's method that should be invoked
     * @param array $methodArguments arguments that should be passed to method
     */
    public function whenInvokedMethod($methodName, $methodArguments = []) {
        call_user_func_array([$this->actual, $methodName], $methodArguments);
    }
}