<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Matchers\Internal\ObjectExceptionMatcher;
use DOMElement;
use PHPUnit_Framework_Assert as Assert;

/**
 * ObjectMatcher is designed to check given object matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class ObjectMatcher extends ValueMatcher {
    public function isInstanceOf($class) {
        Assert::assertInstanceOf($class, $this->actual, $this->description);
        return $this;
    }

    public function isNotInstanceOf($class) {
        Assert::assertNotInstanceOf($class, $this->actual, $this->description);
        return $this;
    }

    /**
     * Asserts that a hierarchy of DOMElements matches.
     *
     * @param DOMElement $expectedElement
     * @return $this
     */
    public function isEqualToXmlStructure(DOMElement $expectedElement) {
        $this->isInstanceOf(DOMElement::class);
        Assert::assertEqualXMLStructure($expectedElement, $this->actual, false, $this->description);
        return $this;
    }

    /**
     * Asserts that a hierarchy of DOMElements matches and ensures attributes of structures also equals.
     *
     * @param DOMElement $expectedElement
     * @return $this
     */
    public function isEqualToXmlStructureAndItsAttributes(DOMElement $expectedElement) {
        $this->isInstanceOf(DOMElement::class);
        Assert::assertEqualXMLStructure($expectedElement, $this->actual, true, $this->description);
        return $this;
    }

    public function hasAttribute($attribute) {
        Assert::assertObjectHasAttribute($attribute, $this->actual, $this->description);
        return $this;
    }

    public function doesNotHaveAttribute($attribute) {
        Assert::assertObjectNotHasAttribute($attribute, $this->actual, $this->description);
        return $this;
    }

    public function throwsException($exceptionClass) {
        $this->expectation->getTest()->expectException($exceptionClass);
        return new ObjectExceptionMatcher($this->expectation, $this->actual, $this->description);
    }
}