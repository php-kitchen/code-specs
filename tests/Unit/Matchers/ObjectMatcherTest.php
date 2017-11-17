<?php

namespace Tests\Unit\Matchers;

use PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher;
use PHPUnit\Framework\TestCase;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link ObjectMatcher}
 *
 * @method ObjectMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher
 *
 * @package Tests\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ObjectMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = ObjectMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createMatcherWithActualValue(new \stdClass());
            $matcherCreated = true;
        } catch (\Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . ObjectMatcher::class);
    }

    /**
     * @covers ::isInstanceOf
     */
    public function testIsInstanceOf() {
        $object = $this->createMatcherWithActualValue($this);
        $object->isInstanceOf(TestCase::class);
    }

    /**
     * @covers ::isNotInstanceOf
     */
    public function testIsNotInstanceOf() {
        $object = $this->createMatcherWithActualValue($this);
        $object->isNotInstanceOf(\Exception::class);
    }

    /**
     * @covers ::isEqualToXmlStructure
     */
    public function testIsEqualToXmlStructure() {
        $actual = <<<XML
<source>
    <a>a</a>
    <b>b</b>
</source>
XML;
        $expected = <<<XML
<source>
    <a dataMine="123">a</a>
    <b>b</b>
</source>
XML;

        $object = $this->createMatcherWithActualValue(dom_import_simplexml(new \SimpleXMLElement($actual)));
        $object->isEqualToXmlStructure(dom_import_simplexml(new \SimpleXMLElement($expected)));
    }

    /**
     * @covers ::isEqualToXmlStructureAndItsAttributes
     */
    public function testIsEqualToXmlStructureAndItsAttributes() {
        $actual = <<<XML
<source>
    <a dataMine="123">a</a>
    <b>b</b>
</source>
XML;
        $expected = <<<XML
<source>
    <a dataMine="123">a</a>
    <b>b</b>
</source>
XML;

        $object = $this->createMatcherWithActualValue(dom_import_simplexml(new \SimpleXMLElement($actual)));
        $object->isEqualToXmlStructureAndItsAttributes(dom_import_simplexml(new \SimpleXMLElement($expected)));
    }

    /**
     * @covers ::hasAttribute
     */
    public function testHasAttribute() {
        $object = $this->createMatcherWithActualValue(new TestDataClass());
        $object->hasAttribute('publicAttribute');
        $object->hasAttribute('protectedAttribute');
    }

    /**
     * @covers ::doesNotHaveAttribute
     */
    public function testDoesNotHaveAttribute() {
        $object = $this->createMatcherWithActualValue(new TestDataClass());
        $object->doesNotHaveAttribute('notExistingAttribute');
    }

    /**
     * @covers ::throwsException
     * @covers  \PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher::withMessage
     * @covers  \PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher::when
     */
    public function testThrowsException() {
        $object = $this->createMatcherWithActualValue(new TestDataClass());
        $object->throwsException(\InvalidArgumentException::class)
            ->withMessage('test exception')
            ->when(function (TestDataClass $object) {
                $object->throwException();
            });
    }
}

class TestDataClass {
    public $publicAttribute;
    protected $protectedAttribute;

    public function throwException() {
        throw new \InvalidArgumentException('test exception');
    }
}