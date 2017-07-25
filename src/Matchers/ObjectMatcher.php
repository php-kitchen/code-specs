<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Matchers\Internal\ObjectExceptionMatcher;
use DOMElement;

/**
 * ObjectMatcher is designed to check given object matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ObjectMatcher extends ValueMatcher {
    public function isInstanceOf($class) {
        $this->registerExpectation('is instance of "' . $class . '"');
        $this->test->assertInstanceOf($class, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotInstanceOf($class) {
        $this->registerExpectation('is not instance of "' . $class . '"');
        $this->test->assertNotInstanceOf($class, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    /**
     * Asserts that a hierarchy of DOMElements matches.
     */
    public function isEqualToXmlStructure(DOMElement $expectedElement) {
        $this->isInstanceOf(DOMElement::class);
        $this->registerExpectation('is equal to expected DOMElement');
        $this->test->assertEqualXMLStructure($expectedElement, $this->actual, false, $this->getMessageForAssert());
        return $this;
    }

    /**
     * Asserts that a hierarchy of DOMElements matches and ensures attributes of structures also equals.
     *
     * @param DOMElement $expectedElement
     * @return $this
     */
    public function isEqualToXmlStructureAndItsAttributes($expectedElement) {
        $this->registerExpectation('is equal to xml structure and it\'s attributes in DOMElement');
        $this->isInstanceOf(DOMElement::class);
        $this->test->assertEqualXMLStructure($expectedElement, $this->actual, true, $this->getMessageForAssert());
        return $this;
    }

    public function hasAttribute($attribute) {
        $this->registerExpectation('has attribute "' . $attribute . '"');
        $this->test->assertObjectHasAttribute($attribute, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotHaveAttribute($attribute) {
        $this->registerExpectation('does not have attribute "' . $attribute . '"');
        $this->test->assertObjectNotHasAttribute($attribute, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function throwsException($exceptionClass): ObjectExceptionMatcher {
        $this->registerExpectation('throws exception "' . $exceptionClass . '"');
        $this->test->expectException($exceptionClass);
        return new ObjectExceptionMatcher($this->actor, $this->test, $this->actual, 'I see that exception "' . $exceptionClass . '"');
    }
}