<?php

namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Matchers\DirectoryMatcher;
use Tests\DeKey\Tester\Base\BaseMatcherTest;

/**
 * Unit test for {@link DirectoryMatcher}
 *
 * @method DirectoryMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\DirectoryMatcher
 *
 * @package Tests\Matchers
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
        // @TODO: this is a bad approach. Need to refactor to not depend on the fact that root dir is not accessible(as it actually might be accessible)
        $directory = $this->createMatcherWithActualValue('/root');
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
        // @TODO: this is a bad approach. Need to refactor to not depend on the fact that root dir is not accessible(as it actually might be accessible)
        $directory = $this->createMatcherWithActualValue('/root');
        $directory->isNotWritable();
    }
}