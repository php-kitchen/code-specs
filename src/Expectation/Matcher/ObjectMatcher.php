<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use DOMElement;
use Exception;
use PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher;

/**
 * ObjectMatcher is designed to check given object matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ObjectMatcher extends ValueMatcher {
    public function isInstanceOf(string $class): self {
        $this->startStep('is instance of "' . $class . '"')
             ->assertInstanceOf($class);

        return $this;
    }

    public function isNotInstanceOf(string $class): self {
        $this->startStep('is not instance of "' . $class . '"')
             ->assertNotInstanceOf($class);

        return $this;
    }

    public function isEqualToXmlStructure(DOMElement $expectedElement): self {
        $this->isInstanceOf(DOMElement::class);
        $this->startStep('is equal to expected DOMElement')
             ->assertEqualXMLStructure($expectedElement, false);

        return $this;
    }

    public function isEqualToXmlStructureAndItsAttributes(DOMElement $expectedElement): self {
        $this->isInstanceOf(DOMElement::class);
        $this->startStep('is equal to xml structure and it\'s attributes in DOMElement')
             ->assertEqualXMLStructure($expectedElement, true);

        return $this;
    }

    public function hasAttribute(string $attribute): self {
        $this->startStep('has attribute "' . $attribute . '"')
             ->assertObjectHasAttribute($attribute);

        return $this;
    }

    public function doesNotHaveAttribute(string $attribute): self {
        $this->startStep('does not have attribute "' . $attribute . '"')
             ->assertObjectNotHasAttribute($attribute);

        return $this;
    }

    /**
     * Start sub-chain of exception matcher.
     *
     * @param Exception|string $exceptionClassOrObject exception class or object that going to be thrown by object
     *
     * @return ObjectExceptionMatcher
     */
    public function throwsException($exceptionClassOrObject): ObjectExceptionMatcher {
        $class = is_string($exceptionClassOrObject) ? $exceptionClassOrObject : get_class($exceptionClassOrObject);
        $matcher = $this->createInternalMatcherWithDescription(ObjectExceptionMatcher::class, 'I see that exception "' . $class . '"');

        $matcher->exceptionClassOrObject = $exceptionClassOrObject;

        return $matcher;
    }
}
