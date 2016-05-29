<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\StringMatcher;

/**
 * Unit test for {@link StringMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\StringMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class StringMatcherTest extends \PHPUnit_Framework_TestCase {
    const FIXTURES_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR;
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new StringMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . StringMatcher::class);
        }
    }

    /**
     * @covers ::contains
     */
    public function testContains() {
        $matcher = $this->createMatcherWithActualValue('abcdefg');
        $matcher->contains('a');
        $matcher->contains('g');
        $matcher->contains('e');
    }

    /**
     * @covers ::doesNotContain
     */
    public function testDoesNotContain() {
        $matcher = $this->createMatcherWithActualValue('abcdefg');
        $matcher->doesNotContain('x');
        $matcher->doesNotContain('z');
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsEqualToJsonFile() {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $matcher = $this->createMatcherWithActualValue($data);
        $matcher->isEqualToJsonFile(self::FIXTURES_DIR . 'jsonFile.json');
    }

    /**
     * @covers ::isEqualToJsonString
     */
    public function testIsEqualToJsonString() {
        $data = json_encode(['a' => 1, 'b' => ['s' => 345]]);
        $matcher = $this->createMatcherWithActualValue($data);
        $matcher->isEqualToJsonString('{"a":1,"b":{"s":345}}');
    }

    /**
     * @covers ::isEqualToFile
     */
    public function testIsEqualToFile() {
        $matcher = $this->createMatcherWithActualValue('abcdefg');
        $matcher->isEqualToFile(self::FIXTURES_DIR . 'txtFile.txt');
    }

    /**
     * @covers ::isNotEqualToFile
     */
    public function testIsNotEqualToFile() {
        $matcher = $this->createMatcherWithActualValue('xcvrt');
        $matcher->isNotEqualToFile(self::FIXTURES_DIR . 'txtFile.txt');
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

        $matcher = $this->createMatcherWithActualValue($xml);
        $matcher->isEqualToXmlString($xml);
    }

    /**
     * @covers ::startsWith
     */
    public function testStartsWith() {
        $matcher = $this->createMatcherWithActualValue('abc');
        $matcher->startsWith('a');
    }

    /**
     * @covers ::doesNotStartWith
     */
    public function testDoesNotStartWith() {
        $matcher = $this->createMatcherWithActualValue('xabc');
        $matcher->doesNotStartWith('a');
    }

    /**
     * @covers ::endsWith
     */
    public function testEndsWith() {
        $matcher = $this->createMatcherWithActualValue('abc');
        $matcher->endsWith('c');
    }

    /**
     * @covers ::doesNotEndWith
     */
    public function testDoesNotEndWith() {
        $matcher = $this->createMatcherWithActualValue('xabc');
        $matcher->doesNotEndWith('x');
    }

    /**
     * @covers ::matchesRegExp
     */
    public function testMatchesRegExp() {
        $matcher = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $matcher->matchesRegExp('/Lorem [\w]+ dolor sit amet/');
    }

    /**
     * @covers ::matchesFormat
     */
    public function testMatchesFormat() {
        $matcher = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $matcher->matchesFormat('Lorem %S dolor sit amet');
    }

    /**
     * @covers ::doesNotMatchFormat
     */
    public function testDoesNotMatchFormat() {
        $matcher = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $matcher->doesNotMatchFormat('Lorem %e dolor sit amet');
    }

    /**
     * @covers ::matchesFormatFromFile
     */
    public function testMatchesFormatFromFile() {
        $matcher = $this->createMatcherWithActualValue('Lorem ipsum dolor sit amet');
        $matcher->matchesFormatFromFile(self::FIXTURES_DIR . 'stringFormat.txt');
    }

    /**
     * @covers ::doesNotMatchFormatFromFile
     */
    public function testDoesNotMatchFormatFromFile() {
        $matcher = $this->createMatcherWithActualValue('Lorem dolor sit amet');
        $matcher->doesNotMatchFormatFromFile(self::FIXTURES_DIR . 'stringFormat.txt');
    }

    protected function createMatcherWithActualValue($value) {
        return new StringMatcher($value, 'matcher does not work');
    }
}