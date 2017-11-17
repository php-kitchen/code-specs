<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use DOMElement;
use PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher;

/**
 * ObjectMatcher is designed to check given object matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ObjectMatcher extends ValueMatcher {
    /**
     * @return $this
     */
    public function isInstanceOf($class): self {
        $this->startStep('is instance of "' . $class . '"')
            ->assertInstanceOf($class);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotInstanceOf($class): self {
        $this->startStep('is not instance of "' . $class . '"')
            ->assertNotInstanceOf($class);
        return $this;
    }

    /**
     * Asserts that a hierarchy of DOMElements matches.
     */
    /**
     * @return $this
     */
    public function isEqualToXmlStructure($expectedElement): self {
        $this->isInstanceOf(DOMElement::class);
        $this->startStep('is equal to expected DOMElement')
            ->assertEqualXMLStructure($expectedElement, false);
        return $this;
    }

    /**
     * Asserts that a hierarchy of DOMElements matches and ensures attributes of structures also equals.
     *
     * @param DOMElement $expectedElement
     * @return $this
     */
    /**
     * @return $this
     */
    public function isEqualToXmlStructureAndItsAttributes($expectedElement): self {
        $this->isInstanceOf(DOMElement::class);
        $this->startStep('is equal to xml structure and it\'s attributes in DOMElement')
            ->assertEqualXMLStructure($expectedElement, true);
        return $this;
    }

    /**
     * @return $this
     */
    public function hasAttribute($attribute): self {
        $this->startStep('has attribute "' . $attribute . '"')
            ->assertObjectHasAttribute($attribute);
        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotHaveAttribute($attribute): self {
        $this->startStep('does not have attribute "' . $attribute . '"')
            ->assertObjectNotHasAttribute($attribute);
        return $this;
    }

    public function throwsException($exceptionClass): ObjectExceptionMatcher {
        $this->startStep('throws exception "' . $exceptionClass . '"')
            ->expectException($exceptionClass);

        return $this->createInternalMatcherWithDescription(ObjectExceptionMatcher::class, 'I see that exception "' . $exceptionClass . '"');
    }
}