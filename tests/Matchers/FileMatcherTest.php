<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\FileMatcher;

/**
 * Unit test for {@link FileMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\FileMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class FileMatcherTest extends \PHPUnit_Framework_TestCase {
    const FIXTURES_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR;

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new FileMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . FileMatcher::class);
        }
    }

    /**
     * @covers ::isExist
     */
    public function testIsExist() {
        $matcher = $this->createMatcherWithActualValue(__FILE__);
        $matcher->isExist();
    }

    /**
     * @covers ::isNotExist
     */
    public function testIsNotExist() {
        $matcher = $this->createMatcherWithActualValue(__FILE__ . 'notExisting');
        $matcher->isNotExist();
    }

    /**
     * @covers ::isEqualTo
     */
    public function testIsEqualTo() {
        $matcher = $this->createMatcherWithActualValue(__FILE__);
        $matcher->isEqualTo(__FILE__);
    }

    /**
     * @covers ::isNotEqualTo
     */
    public function testIsNotEqualTo() {
        $matcher = $this->createMatcherWithActualValue(__FILE__);
        $matcher->isNotEqualTo(__DIR__ . DIRECTORY_SEPARATOR . 'ObjectMatcherTest.php');
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsEqualToJsonFile() {
        $jsonFile = self::FIXTURES_DIR . 'jsonFile.json';
        $matcher = $this->createMatcherWithActualValue($jsonFile);
        $matcher->isEqualToJsonFile($jsonFile);
    }

    /**
     * @covers ::isNotEqualToJsonFile
     */
    public function testIsNotEqualToJsonFile() {
        $jsonFile = self::FIXTURES_DIR . 'jsonFile.json';
        $anotherJsonFile = self::FIXTURES_DIR . 'jsonFile2.json';
        $matcher = $this->createMatcherWithActualValue($jsonFile);
        $matcher->isNotEqualToJsonFile($anotherJsonFile);
    }

    protected function createMatcherWithActualValue($value) {
        return new FileMatcher($value, 'matcher does not work');
    }
}