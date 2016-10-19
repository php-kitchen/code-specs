<?php
namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Matchers\FileMatcher;
use Tests\DeKey\Tester\Base\BaseMatcherTest;

/**
 * Unit test for {@link FileMatcher}
 *
 * @method FileMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\FileMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class FileMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = FileMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createMatcherWithActualValue('');
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . FileMatcher::class);
        }
    }

    /**
     * @covers ::isExist
     */
    public function testIsExist() {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isExist();
    }

    /**
     * @covers ::isNotExist
     */
    public function testIsNotExist() {
        $file = $this->createMatcherWithActualValue(__FILE__ . 'notExisting');
        $file->isNotExist();
    }

    /**
     * @covers ::isEqualTo
     */
    public function testIsEqualTo() {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isEqualTo(__FILE__);
    }

    /**
     * @covers ::isNotEqualTo
     */
    public function testIsNotEqualTo() {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isNotEqualTo(__DIR__ . DIRECTORY_SEPARATOR . 'ObjectMatcherTest.php');
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsEqualToJsonFile() {
        $jsonFile = self::FIXTURES_DIR . 'jsonFile.json';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isEqualToJsonFile($jsonFile);
    }

    /**
     * @covers ::isNotEqualToJsonFile
     */
    public function testIsNotEqualToJsonFile() {
        $jsonFile = self::FIXTURES_DIR . 'jsonFile.json';
        $anotherJsonFile = self::FIXTURES_DIR . 'jsonFile2.json';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isNotEqualToJsonFile($anotherJsonFile);
    }

    /**
     * @covers ::isEqualToXmlFile
     */
    public function testIsEqualToXmlFile() {
        $jsonFile = self::FIXTURES_DIR . 'xmlFile.xml';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isEqualToXmlFile($jsonFile);
    }

    /**
     * @covers ::isNotEqualToXmlFile
     */
    public function testIsNotEqualToXmlFile() {
        $jsonFile = self::FIXTURES_DIR . 'xmlFile.xml';
        $anotherJsonFile = self::FIXTURES_DIR . 'xmlFile2.xml';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isNotEqualToXmlFile($anotherJsonFile);
    }

    /**
     * @covers ::isReadable
     */
    public function testIsReadable() {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isReadable();
    }

    /**
     * @covers ::isNotReadable
     */
    public function testIsNotReadable() {
        // @TODO: this is a bad approach. Need to refactor to not depend on the fact that root dir is not accessible(as it actually might be accessible)
        $file = $this->createMatcherWithActualValue('/root');
        $file->isNotReadable();
    }

    /**
     * @covers ::isWritable
     */
    public function testIsWritable() {
        $file = $this->createMatcherWithActualValue(tempnam('/tmp', 'tester'));
        $file->isWritable();
    }

    /**
     * @covers ::isNotWritable
     */
    public function testIsNotWritable() {
        // @TODO: this is a bad approach. Need to refactor to not depend on the fact that root dir is not accessible(as it actually might be accessible)
        $file = $this->createMatcherWithActualValue('/root');
        $file->isNotWritable();
    }
}