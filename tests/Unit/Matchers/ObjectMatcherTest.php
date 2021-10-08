<?php

namespace Tests\Unit\Matchers;

use Exception;
use InvalidArgumentException;
use PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use stdClass;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link ObjectMatcher}
 *
 * @method ObjectMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\ObjectMatcher
 *
 * @package Tests\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ObjectMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass(): void {
        $this->matcherClass = ObjectMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate(): void {
        try {
            $this->createMatcherWithActualValue(new stdClass());
            $matcherCreated = true;
        } catch (Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . ObjectMatcher::class);
    }

    /**
     * @covers ::isInstanceOf
     */
    public function testIsInstanceOf(): void {
        $object = $this->createMatcherWithActualValue($this);
        $object->isInstanceOf(TestCase::class);
    }

    /**
     * @covers ::isNotInstanceOf
     */
    public function testIsNotInstanceOf(): void {
        $object = $this->createMatcherWithActualValue($this);
        $object->isNotInstanceOf(Exception::class);
    }

    /**
     * @covers ::isEqualToXmlStructure
     */
    public function testIsEqualToXmlStructure(): void {
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

        $object = $this->createMatcherWithActualValue(dom_import_simplexml(new SimpleXMLElement($actual)));
        $object->isEqualToXmlStructure(dom_import_simplexml(new SimpleXMLElement($expected)));
    }

    /**
     * @covers ::isEqualToXmlStructureAndItsAttributes
     */
    public function testIsEqualToXmlStructureAndItsAttributes(): void {
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

        $object = $this->createMatcherWithActualValue(dom_import_simplexml(new SimpleXMLElement($actual)));
        $object->isEqualToXmlStructureAndItsAttributes(dom_import_simplexml(new SimpleXMLElement($expected)));
    }

    /**
     * @covers ::hasAttribute
     */
    public function testHasAttribute(): void {
        $object = $this->createMatcherWithActualValue(new TestDataClass());
        $object->hasAttribute('publicAttribute');
        $object->hasAttribute('protectedAttribute');
    }

    /**
     * @covers ::doesNotHaveAttribute
     */
    public function testDoesNotHaveAttribute(): void {
        $object = $this->createMatcherWithActualValue(new TestDataClass());
        $object->doesNotHaveAttribute('notExistingAttribute');
    }

    /**
     * @covers ::throwsException
     * @covers  \PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher::withMessage
     * @covers  \PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher::when
     */
    public function testThrowsException(): void {
        $this->markTestSkipped('need to fix'); //@TODO
        $object = $this->createMatcherWithActualValue(new TestDataClass());
        $object->throwsException(InvalidArgumentException::class)
               ->withMessage('test exception')
               ->when(function (TestDataClass $object) {
                   $object->throwException();
               });
    }

    /**
     * @covers ::throwsException
     * @covers  \PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher::withMessage
     * @covers  \PHPKitchen\CodeSpecs\Expectation\Internal\ObjectExceptionMatcher::when
     */
    public function testThrowsExceptionWithObject(): void {
        $this->markTestSkipped('need to fix'); //@TODO
        $object = $this->createMatcherWithActualValue(new TestDataClass());
        $object->throwsException(new InvalidArgumentException('test exception'))
               ->when(function (TestDataClass $object) {
                   $object->throwException();
               });
    }
}

class TestDataClass {
    public $publicAttribute;
    protected $protectedAttribute;

    public function throwException(): void {
        throw new InvalidArgumentException('test exception');
    }
}
