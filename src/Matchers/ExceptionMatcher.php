<?php

namespace DeKey\Tester\Matchers;

use PHPUnit_Framework_Assert as Assert;

/**
 * ExceptionMatcher is designed to check given exception matches expectation.
 *
 * @property \Exception $actual
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko
 */
class ExceptionMatcher extends ObjectMatcher {
    public function hasMessage($message) {
        Assert::assertEquals($message, $this->actual->getMessage(), $this->description);
        return $this;
    }

    public function hasMessageMatchesPattern($messagePattern) {
        Assert::assertRegExp($messagePattern, $this->actual->getMessage(), $this->description);
        return $this;
    }

    public function hasCode($code) {
        Assert::assertEquals($code, $this->actual->getCode(), $this->description);
        return $this;
    }
}