<?php
namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Matchers\StringMatcher;
use Tests\DeKey\Tester\Base\BaseMatcherTest;

/**
 * Unit test for {@link StringMatcher}
 *
 * @method StringMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\StringMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class StringMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = StringMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createMatcherWithActualValue('');
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . StringMatcher::class);
        }
    }

    /**
     * @covers ::contains
     */
    public function testContains() {
        $string = $this->createMatcherWithActualValue('abcdefg');
        $string->contains('a');
        $string->contains('g');
        $string->contains('e');
    }

    /**
     * @covers ::doesNotContain
     */
    public function testDoesNotContain() {
        $string = $this->createMatcherWithActualValue('abcdefg');
        $string->doesNotContain('x');
        $string->doesNotContain('z');
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsJson() {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isJson();
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsEqualToJsonFile() {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isEqualToJsonFile(self::FIXTURES_DIR . 'jsonFile.json');
    }

    /**
     * @covers ::isNotEqualToJsonFile
     */
    public function testIsNotEqualToJsonFile() {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isNotEqualToJsonFile(self::FIXTURES_DIR . 'jsonFile2.json');
    }

    /**
     * @covers ::isEqualToJsonString
     */
    public function testIsEqualToJsonString() {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isEqualToJsonString('{"a":1,"b":{"s":345}}');
    }

    /**
     * @covers ::isNotEqualToJsonString
     */
    public function testIsNotEqualToJsonString() {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345], 'c' => 5]);
        $string = $this->createMatcherWithActualValue($data);
        $string->isNotEqualToJsonString('{"a":1,"b":{"s":345}}');
    }

    /**
     * @covers ::isEqualToFile
     */
    public function testIsEqualToFile() {
        $string = $this->createMatcherWithActualValue('abcdefg');
        $string->isEqualToFile(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isNotEqualToFile
     */
    public function testIsNotEqualToFile() {
        $string = $this->createMatcherWithActualValue('xcvrt');
        $string->isNotEqualToFile(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isEqualToXmlFile
     */
    public function testIsEqualToXmlFile() {
        $xmlFile = self::FIXTURES_DIR . 'xmlFile.xml';
        $xml = file_get_contents($xmlFile);

        $string = $this->createMatcherWithActualValue($xml);
        $string->isEqualToXmlFile($xmlFile);
    }

    /**
     * @covers ::isNotEqualToXmlFile
     */
    public function testIsNotEqualToXmlFile() {
        $xml = file_get_contents(self::FIXTURES_DIR . 'xmlFile2.xml');

        $string = $this->createMatcherWithActualValue($xml);
        $string->isNotEqualToXmlFile(self::FIXTURES_DIR . 'xmlFile.xml');
    }

    /**
     * @covers ::isEqualToXmlString
     */
    public function testIsEqualToXmlString() {
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
    public function testIsNotEqualToXmlString() {
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
    public function testStartsWith() {
        $string = $this->createMatcherWithActualValue('abc');
        $string->startsWith('a');
    }

    /**
     * @covers ::doesNotStartWith
     */
    public function testDoesNotStartWith() {
        $string = $this->createMatcherWithActualValue('xabc');
        $string->doesNotStartWith('a');
    }

    /**
     * @covers ::endsWith
     */
    public function testEndsWith() {
        $string = $this->createMatcherWithActualValue('abc');
        $string->endsWith('c');
    }

    /**
     * @covers ::doesNotEndWith
     */
    public function testDoesNotEndWith() {
        $string = $this->createMatcherWithActualValue('xabc');
        $string->doesNotEndWith('x');
    }

    /**
     * @covers ::matchesRegExp
     */
    public function testMatchesRegExp() {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->matchesRegExp('/Lorem [\w]+ dolor sit amet/');
    }

    /**
     * @covers ::matchesFormat
     */
    public function testMatchesFormat() {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->matchesFormat('Lorem %S dolor sit amet');
    }

    /**
     * @covers ::doesNotMatchFormat
     */
    public function testDoesNotMatchFormat() {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->doesNotMatchFormat('Lorem %e dolor sit amet');
    }

    /**
     * @covers ::matchesFormatFromFile
     */
    public function testMatchesFormatFromFile() {
        $string = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $string->matchesFormatFromFile(self::FIXTURES_DIR . 'stringFormat.txt');
    }

    /**
     * @covers ::doesNotMatchFormatFromFile
     */
    public function testDoesNotMatchFormatFromFile() {
        $string = $this->createMatcherWithActualValue('Lorem dolor sit amet');
        $string->doesNotMatchFormatFromFile(self::FIXTURES_DIR . 'stringFormat.txt');
    }
}