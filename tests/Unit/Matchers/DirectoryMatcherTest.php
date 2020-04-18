<?php

namespace Tests\Unit\Matchers;

use PHPKitchen\CodeSpecs\Expectation\Matcher\DirectoryMatcher;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link DirectoryMatcher}
 *
 * @method DirectoryMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\DirectoryMatcher
 *
 * @package Tests\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class DirectoryMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = DirectoryMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createMatcherWithActualValue('');
            $matcherCreated = true;
        } catch (\Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . DirectoryMatcher::class);
    }

    /**
     * @covers ::isExist
     */
    public function testIsExist() {
        $directory = $this->createMatcherWithActualValue(__DIR__);
        $directory->isExist();
    }

    /**
     * @covers ::isNotExist
     */
    public function testIsNotExist() {
        $directory = $this->createMatcherWithActualValue(__DIR__ . 'notExistingDirectory');
        $directory->isNotExist();
    }

    /**
     * @covers ::isReadable
     */
    public function testIsReadable() {
        $directory = $this->createMatcherWithActualValue(__DIR__);
        $directory->isReadable();
    }

    /**
     * @covers ::isNotReadable
     */
    public function testIsNotReadable() {
        $directory = $this->createMatcherWithActualValue('/etc');
        $directory->isNotReadable();
    }

    /**
     * @covers ::isWritable
     */
    public function testIsWritable() {
        $directory = $this->createMatcherWithActualValue('/tmp');
        $directory->isWritable();
    }

    /**
     * @covers ::isNotWritable
     */
    public function testIsNotWritable() {
        $directory = $this->createMatcherWithActualValue('/dgfdg');
        $directory->isNotWritable();
    }
}