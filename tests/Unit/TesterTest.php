<?php

namespace Tests\Unit;

use DeKey\Tester\Specification\Specification;

/**
 * Unit test for {@link \DeKey\Tester\Specification\Tester}
 *
 * @coversDefaultClass \DeKey\CodeSpecs\Specification\Tester
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class TesterTest extends Specification {
    /**
     * @covers ::seeThatBoolean
     * @covers ::<protected>
     */
    public function testSeeThatBoolean() {
        $I = $this->tester;
        $I->seeThatBoolean(true)->isTrue();
        $I->seeThatBoolean(false)->isFalse();
    }

    /**
     * @covers ::seeThatClass
     * @covers ::<protected>
     */
    public function testSeeThatTheClass() {
        $I = $this->tester;
        $thisClass = get_class($this);
        $I->seeThatClass($thisClass)->isExist();
    }

    /**
     * @covers ::seeThatValueOf
     * @covers ::<protected>
     */
    public function testSeeThatValueOf() {
        $I = $this->tester;
        $I->seeThatValueOf(1)->isNotEmpty();
    }

    /**
     * @covers ::seeThatString
     * @covers ::<protected>
     */
    public function testSeeThatString() {
        $I = $this->tester;
        $I->seeThatString('')->isEmpty();
    }

    /**
     * @covers ::seeThatArray
     * @covers ::<protected>
     */
    public function testSeeThatTheArray() {
        $I = $this->tester;
        $I->seeThatArray([])->isEmpty();
    }

    /**
     * @covers ::seeThatObject
     * @covers ::<protected>
     */
    public function testSeeThatObject() {
        $I = $this->tester;
        $I->seeThatObject($this)->isNotEmpty();
    }

    /**
     * @covers ::seeThatFile
     * @covers ::<protected>
     */
    public function testSeeThatFile() {
        $I = $this->tester;
        $I->seeThatFile(__FILE__)->isExist()->isEqualTo(__FILE__);
    }

    /**
     * @covers ::seeThatDirectory
     * @covers ::<protected>
     */
    public function testSeeThatDirectory() {
        $I = $this->tester;
        $I->seeThatDirectory(__DIR__)->isExist();
    }

    /**
     * @covers ::seeThatNumber
     * @covers ::<protected>
     */
    public function testSeeThatNumber() {
        $I = $this->tester;
        $I->seeThatNumber(1)->isFinite();
    }

    /**
     * @covers ::getStepsListAsString
     * @covers ::<protected>
     */
    public function testGetStepsListAsString() {
        $I = $this->tester;
        $message = 'nothing cached';
        try {
            $I->expectThat('output contains all of the steps and mark checked expectations as succeeded');
            $I->seeThatNumber(1)->isNotEmpty()->isNull();
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $expectedOutput = <<<TEXT
✓ I expect that output contains all of the steps and mark checked expectations as succeeded
✓ I see that number is not empty.
- I see that number is null.

Failed asserting that 1 is null.
TEXT;

        $this->assertEquals($expectedOutput, $message);
    }
}
