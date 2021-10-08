<?php

namespace Tests\Unit\Matchers;

use Exception;
use PHPKitchen\CodeSpecs\Expectation\Matcher\StringMatcher;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link StringMatcher}
 *
 * @method StringMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\StringMatcher
 *
 * @package Tests\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class StringMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass(): void {
        $this->matcherClass = StringMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate(): void {
        try {
            $this->createMatcherWithActualValue('');
            $matcherCreated = true;
        } catch (Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . StringMatcher::class);
    }

    /**
     * @covers ::containsString
     */
    public function testContains(): void {
        $string = $this->createMatcherWithActualValue('Abcdefg');
        $string->containsString('A');
        $string->containsString('e');
        $string->containsString('g');
    }

    /**
     * @covers ::doesNotContainsString
     */
    public function testDoesNotContain(): void {
        $string = $this->createMatcherWithActualValue('Abcdefg');
        $string->doesNotContainsString('a');
        $string->doesNotContainsString('x');
    }

    /**
     * @covers ::containsStringIgnoringCase
     */
    public function testContainsStringIgnoringCase(): void {
        $string = $this->createMatcherWithActualValue('AbcdefG');
        $string->containsStringIgnoringCase('a');
        $string->containsStringIgnoringCase('e');
        $string->containsStringIgnoringCase('g');
    }

    /**
     * @covers ::doesNotContainsStringIgnoringCase
     */
    public function testDoesNotContainsStringIgnoringCase(): void {
        $string = $this->createMatcherWithActualValue('abcdefg');
        $string->doesNotContainsStringIgnoringCase('x');
        $string->doesNotContainsStringIgnoringCase('z');
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsJson(): void {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isJson();
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsEqualToJsonFile(): void {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isEqualToJsonFile(self::FIXTURES_DIR . 'jsonFile.json');
    }

    /**
     * @covers ::isNotEqualToJsonFile
     */
    public function testIsNotEqualToJsonFile(): void {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isNotEqualToJsonFile(self::FIXTURES_DIR . 'jsonFile2.json');
    }

    /**
     * @covers ::isEqualToJsonString
     */
    public function testIsEqualToJsonString(): void {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isEqualToJsonString('{"a":1,"b":{"s":345}}');
    }

    /**
     * @covers ::isNotEqualToJsonString
     */
    public function testIsNotEqualToJsonString(): void {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345], 'c' => 5]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isNotEqualToJsonString('{"a":1,"b":{"s":345}}');
    }

    /**
     * @covers ::isEqualToFile
     */
    public function testIsEqualToFile(): void {
        $string = $this->createMatcherWithActualValue('abcdefg');
        $string->isEqualToFile(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isEqualsToFileCanonicalizing
     */
    public function testIsEqualsToFileCanonicalizing(): void {
        $string = $this->createMatcherWithActualValue('abcdefg');
        $string->isEqualsToFileCanonicalizing(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isEqualsToFileIgnoringCase
     */
    public function testIiEqualsToFileIgnoringCase(): void {
        $string = $this->createMatcherWithActualValue('ABCdefg');
        $string->isEqualsToFileIgnoringCase(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isNotEqualToFile
     */
    public function testIsNotEqualToFile(): void {
        $string = $this->createMatcherWithActualValue('xcvrt');
        $string->isNotEqualToFile(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isNotEqualsToFileCanonicalizing
     */
    public function testIsNotEqualsFileCanonicalizing(): void {
        $string = $this->createMatcherWithActualValue('xcvrt');
        $string->isNotEqualsToFileCanonicalizing(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isNotEqualsToFileIgnoringCase
     */
    public function testIsNotEqualsFileIgnoringCase(): void {
        $string = $this->createMatcherWithActualValue('XCVrt');
        $string->isNotEqualsToFileIgnoringCase(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isEqualToXmlFile
     */
    public function testIsEqualToXmlFile(): void {
        $xmlFile = self::FIXTURES_DIR . 'xmlFile.xml';
        $xml = file_get_contents($xmlFile);

        $string = $this->createMatcherWithActualValue($xml);
        $string->isEqualToXmlFile($xmlFile);
    }

    /**
     * @covers ::isNotEqualToXmlFile
     */
    public function testIsNotEqualToXmlFile(): void {
        $xml = file_get_contents(self::FIXTURES_DIR . 'xmlFile2.xml');

        $string = $this->createMatcherWithActualValue($xml);
        $string->isNotEqualToXmlFile(self::FIXTURES_DIR . 'xmlFile.xml');
    }

    /**
     * @covers ::isEqualToXmlString
     */
    public function testIsEqualToXmlString(): void {
        $xml = <<<XML
<source>
	<a>a</a>
	<b>b</b>
</source>
XML;

        $string = $this->createMatcherWithActualValue($xml);
        $string->isEqualToXmlString($xml);
    }

    /**
     * @covers ::isNotEqualToXmlString
     */
    public function testIsNotEqualToXmlString(): void {
        $actual = <<<XML
<source>
	<a>a</a>
	<b>b</b>
</source>
XML;
        $notExpected = <<<XML
<source>
	<a>a</a>
	<b>b</b>
	<c>c</c>
</source>
XML;

        $string = $this->createMatcherWithActualValue($actual);
        $string->isNotEqualToXmlString($notExpected);
    }

    /**
     * @covers ::startsWith
     */
    public function testStartsWith(): void {
        $string = $this->createMatcherWithActualValue('abc');
        $string->startsWith('a');
    }

    /**
     * @covers ::doesNotStartWith
     */
    public function testDoesNotStartWith(): void {
        $string = $this->createMatcherWithActualValue('xabc');
        $string->doesNotStartWith('a');
    }

    /**
     * @covers ::endsWith
     */
    public function testEndsWith(): void {
        $string = $this->createMatcherWithActualValue('abc');
        $string->endsWith('c');
    }

    /**
     * @covers ::doesNotEndWith
     */
    public function testDoesNotEndWith(): void {
        $string = $this->createMatcherWithActualValue('xabc');
        $string->doesNotEndWith('x');
    }

    /**
     * @covers ::matchesRegExp
     */
    public function testMatchesRegExp(): void {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->matchesRegExp('/Lorem [\w]+ dolor sit amet/');
    }

    /**
     * @covers ::matchesFormat
     */
    public function testMatchesFormat(): void {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->matchesFormat('Lorem %S dolor sit amet');
    }

    /**
     * @covers ::doesNotMatchFormat
     */
    public function testDoesNotMatchFormat(): void {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->doesNotMatchFormat('Lorem %e dolor sit amet');
    }

    /**
     * @covers ::matchesFormatFromFile
     */
    public function testMatchesFormatFromFile(): void {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->matchesFormatFromFile(self::FIXTURES_DIR . 'stringFormat.txt');
    }

    /**
     * @covers ::doesNotMatchFormatFromFile
     */
    public function testDoesNotMatchFormatFromFile(): void {
        $string = $this->createMatcherWithActualValue('Lorem dolor sit amet');
        $string->doesNotMatchFormatFromFile(self::FIXTURES_DIR . 'stringFormat.txt');
    }
}
