<?php

namespace Tests\Base;

/**
 * Represents tests of {@link \PHPKitchen\CodeSpecs\Mixin\TestGuyMethods}
 *
 * This trait designed to be used in PHPUnit and Codeception integration tests.
 *
 * @property \PHPKitchen\CodeSpecs\Contract\TestGuy $tester
 *
 * @package Tests\Base
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
trait TestGuyTests {
    /**
     * @covers ::seeBool
     * @covers ::<protected>
     */
    public function testSeeBool() {
        $I = $this->tester;
        $I->seeBool(true)->isTrue();
        $I->seeBool(false)->isFalse();
    }

    /**
     * @covers ::seeClass
     * @covers ::<protected>
     */
    public function testSeeClass() {
        $I = $this->tester;
        $thisClass = get_class($this);
        $I->seeClass($thisClass)->isExist();
    }

    /**
     * @covers ::see
     * @covers ::<protected>
     */
    public function testSee() {
        $I = $this->tester;
        $I->see(1)->isNotEmpty();
    }

    /**
     * @covers ::seeString
     * @covers ::<protected>
     */
    public function testSeeString() {
        $I = $this->tester;
        $I->seeString('')->isEmpty();
    }

    /**
     * @covers ::seeArray
     * @covers ::<protected>
     */
    public function testSeeTheArray() {
        $I = $this->tester;
        $I->seeArray([])->isEmpty();
    }

    /**
     * @covers ::seeObject
     * @covers ::<protected>
     */
    public function testSeeObject() {
        $I = $this->tester;
        $I->seeObject($this)->isNotEmpty();
    }

    /**
     * @covers ::seeFile
     * @covers ::<protected>
     */
    public function testSeeFile() {
        $I = $this->tester;
        $I->seeFile(__FILE__)->isExist()->isEqualTo(__FILE__);
    }

    /**
     * @covers ::seeDirectory
     * @covers ::<protected>
     */
    public function testSeeDirectory() {
        $I = $this->tester;
        $I->seeDirectory(__DIR__)->isExist();
    }

    /**
     * @covers ::seeNumber
     * @covers ::<protected>
     */
    public function testSeeNumber() {
        $I = $this->tester;
        $I->seeNumber(1)->isFinite();
    }

    public function testErrorOutput() {
        $I = $this->tester;
        $message = 'nothing cached';
        try {
            $I->expectThat('output contains all of the steps and mark checked expectations as succeeded');
            $I->seeNumber(1)->isNotEmpty()->isNull();
        } catch (\Throwable $e) {
            $message = $e->getMessage();
        }

        $expectedOutput = <<<TEXT
✓ I expect that output contains all of the steps and mark checked expectations as succeeded
✓ I see that number is not empty.
- I see that number is null.

Failed asserting that 1 is null.
TEXT;
        // hack to test in windows Docker containers
        $expectedOutput = str_replace("\r", "", $expectedOutput);

        $this->assertEquals($expectedOutput, $message);
    }

    /**
     * @covers ::match
     * @covers ::<protected>
     */
    public function testMatch() {
        $I = $this->tester;

        try {
            $matchArrayHasName = $I->match('dummy variable')->isArray()->hasKey('name');
        } catch (\Throwable $e) {
            $this->fail('Failed to create runtime matcher. Error is:' . $e->getMessage());
        }

        $expectedOutput = "- I see that dummy variable has key \"name\".\n\nFailed asserting that an array has the key 'name'.";
        $message = 'Matcher did not executed correctly.';
        try {
            $matchArrayHasName([]);
        } catch (\Throwable $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals($expectedOutput, $message, 'Runtime matcher should execute previously defined asserts and throw exception with defined steps');
    }
}