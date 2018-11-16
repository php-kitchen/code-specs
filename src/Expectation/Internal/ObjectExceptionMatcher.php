<?php

namespace PHPKitchen\CodeSpecs\Expectation\Internal;

use PHPKitchen\CodeSpecs\Expectation\Matcher\Base\Matcher;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher;

/**
 * ExceptionMatcher is designed to check that object throws valid exception.
 * This matcher being used in pair with {@link ObjectMatcher}.
 *
 * @property \Exception $actual
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ObjectExceptionMatcher extends Matcher {
    public $exceptionClassOrObject;
    public function withMessage($message) {
        $this->startStep('has message "' . $message . '"')
             ->expectExceptionMessage($message);

        return $this;
    }

    public function withMessageMatchesPattern($messagePattern) {
        $this->startStep('has message matching pattern "' . $messagePattern . '"')
             ->expectExceptionMessageRegExp($messagePattern);

        return $this;
    }

    public function withCode($code) {
        $this->startStep('has code "' . $code . '"')
             ->expectExceptionCode($code);

        return $this;
    }

    /**
     * Identifies a situation when exception should be raised.
     * Supposed to executes method of the object.
     * This methods should to be used after {@link throwsException} and "with*" methods to gain expression like:
     * <pre>
     * $I->seeObject($a)->throwsException(Exception::class)->when(function($object) {$object->doParty();});
     * // or
     * $I->seeObject($a)->throwsException(IronyException::class)->withCode(500)->when(function($object) {$object->doParty();});
     * <pre/>
     * and finish scenario.
     */
    public function when(callable $callback) {
        $exceptionClassOrObject = $this->exceptionClassOrObject;
        if (is_string($exceptionClassOrObject)) {
            $this->startStep('throws exception "' . $exceptionClassOrObject . '"')
                 ->expectException($this->exceptionClassOrObject);
        } else {
            $this->startStep('throws exception "' . get_class($exceptionClassOrObject) . '"')
                 ->expectExceptionObject($this->exceptionClassOrObject);
        }

        call_user_func_array($callback, [$this->getActualValue()]);
    }
}


