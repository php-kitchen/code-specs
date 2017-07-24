<?php

namespace Tests\DeKey\Tester\Unit;

use DeKey\Tester\TesterExpectation;
use Tests\DeKey\Tester\Base\TestCase;

/**
 * Unit test for {@link TesterExpectation}
 *
 * @deprecated
 * @coversDefaultClass \DeKey\Tester\TesterExpectation
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class TesterExpectationTest extends TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {

        try {
            (new TesterExpectation($this->tester, $this));
            $expectationCreated = true;
        } catch (\Exception $e) {
            $expectationCreated = false;
        }
        $this->assertTrue($expectationCreated, 'Unable to create tester expectation ' . TesterExpectation::class);
    }

    /**
     * @covers ::boolean
     * @covers ::<protected>
     */
    public function testBoolean() {
        $tester = $this->createExpectation();
        $tester->boolean(true)->isTrue();
        $tester->boolean(false)->isFalse();
    }

    /**
     * @covers ::theClass
     * @covers ::<protected>
     */
    public function testTheClass() {
        $tester = $this->createExpectation();
        $thisClass = get_class($this);
        $tester->theClass($thisClass)->isExist();
    }

    /**
     * @covers ::valueOf
     * @covers ::<protected>
     */
    public function testValueOf() {
        $tester = $this->createExpectation();
        $tester->valueOf(1)->isNotEmpty();
    }

    /**
     * @covers ::string
     * @covers ::<protected>
     */
    public function testString() {
        $tester = $this->createExpectation();
        $tester->string('')->isEmpty();
    }

    /**
     * @covers ::theArray
     * @covers ::<protected>
     */
    public function testTheArray() {
        $tester = $this->createExpectation();
        $tester->theArray([])->isEmpty();
    }

    /**
     * @covers ::object
     * @covers ::<protected>
     */
    public function testObject() {
        $tester = $this->createExpectation();
        $tester->object($this)->isNotEmpty();
    }

    /**
     * @covers ::file
     * @covers ::<protected>
     */
    public function testFile() {
        $tester = $this->createExpectation();
        $tester->file(__FILE__)->isExist()->isEqualTo(__FILE__);
    }

    /**
     * @covers ::directory
     * @covers ::<protected>
     */
    public function testDirectory() {
        $tester = $this->createExpectation();
        $tester->directory(__DIR__)->isExist();
    }

    /**
     * @covers ::number
     * @covers ::<protected>
     */
    public function testNumber() {
        $tester = $this->createExpectation();
        $tester->number(1)->isFinite();
    }

    protected function createExpectation() {
        return new TesterExpectation($this->tester, $this);
    }
}
