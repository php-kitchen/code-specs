<?php

namespace Tests\Unit\Matchers;

use Exception;
use PHPKitchen\CodeSpecs\Expectation\Matcher\FileMatcher;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link FileMatcher}
 *
 * @method FileMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\FileMatcher
 *
 * @package Tests\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class FileMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass(): void {
        $this->matcherClass = FileMatcher::class;
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
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . FileMatcher::class);
    }

    /**
     * @covers ::isExist
     */
    public function testIsExist(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isExist();
    }

    /**
     * @covers ::isNotExist
     */
    public function testIsNotExist(): void {
        $file = $this->createMatcherWithActualValue(__FILE__ . 'notExisting');
        $file->isNotExist();
    }

    /**
     * @covers ::isEqualTo
     */
    public function testIsEqualTo(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isEqualTo(__FILE__);
    }

    /**
     * @covers ::isEqualCanonicalizingTo
     */
    public function testIsEqualCanonicalizingTo(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isEqualCanonicalizingTo(__FILE__);
    }

    /**
     * @covers ::isEqualIgnoringCaseTo
     */
    public function testIsEqualIgnoringCaseTo(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isEqualIgnoringCaseTo(__FILE__);
    }

    /**
     * @covers ::isNotEqualTo
     */
    public function testIsNotEqualTo(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isNotEqualTo(__DIR__ . DIRECTORY_SEPARATOR . 'ObjectMatcherTest.php');
    }

    /**
     * @covers ::isNotEqualCanonicalizingTo
     */
    public function testIsNotEqualCanonicalizingTo(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isNotEqualCanonicalizingTo(__DIR__ . DIRECTORY_SEPARATOR . 'ObjectMatcherTest.php');
    }

    /**
     * @covers ::isNotEqualIgnoringCaseTo
     */
    public function testIsNotEqualIgnoringCaseTo(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isNotEqualIgnoringCaseTo(__DIR__ . DIRECTORY_SEPARATOR . 'ObjectMatcherTest.php');
    }

    /**
     * @covers ::isEqualToJsonFile
     */
    public function testIsEqualToJsonFile(): void {
        $jsonFile = self::FIXTURES_DIR . 'jsonFile.json';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isEqualToJsonFile($jsonFile);
    }

    /**
     * @covers ::isNotEqualToJsonFile
     */
    public function testIsNotEqualToJsonFile(): void {
        $jsonFile = self::FIXTURES_DIR . 'jsonFile.json';
        $anotherJsonFile = self::FIXTURES_DIR . 'jsonFile2.json';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isNotEqualToJsonFile($anotherJsonFile);
    }

    /**
     * @covers ::isEqualToXmlFile
     */
    public function testIsEqualToXmlFile(): void {
        $jsonFile = self::FIXTURES_DIR . 'xmlFile.xml';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isEqualToXmlFile($jsonFile);
    }

    /**
     * @covers ::isNotEqualToXmlFile
     */
    public function testIsNotEqualToXmlFile(): void {
        $jsonFile = self::FIXTURES_DIR . 'xmlFile.xml';
        $anotherJsonFile = self::FIXTURES_DIR . 'xmlFile2.xml';
        $file = $this->createMatcherWithActualValue($jsonFile);
        $file->isNotEqualToXmlFile($anotherJsonFile);
    }

    /**
     * @covers ::isReadable
     */
    public function testIsReadable(): void {
        $file = $this->createMatcherWithActualValue(__FILE__);
        $file->isReadable();
    }

    /**
     * @covers ::isNotReadable
     */
    public function testIsNotReadable(): void {
        // @TODO: this is a bad approach. Need to refactor to not depend on the fact that root dir is not accessible(as it actually might be accessible)
        $file = $this->createMatcherWithActualValue('/root');
        $file->isNotReadable();
    }

    /**
     * @covers ::isWritable
     */
    public function testIsWritable(): void {
        $file = $this->createMatcherWithActualValue(tempnam('/tmp', 'tester'));
        $file->isWritable();
    }

    /**
     * @covers ::isNotWritable
     */
    public function testIsNotWritable(): void {
        // @TODO: this is a bad approach. Need to refactor to not depend on the fact that root dir is not accessible(as it actually might be accessible)
        $file = $this->createMatcherWithActualValue('/root');
        $file->isNotWritable();
    }
}
