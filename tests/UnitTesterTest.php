<?php

namespace Tests;

use DeKey\Tester\UnitTester;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for {@link UnitTester}
 *
 * @coversDefaultClass \DeKey\Tester\UnitTester
 *
 * @package Tests
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class UnitTesterTest extends PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        $mock = $this->getMock(PHPUnit_Framework_TestCase::class);
        try {
            (new UnitTester($mock));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate UnitTester. Error message is: ' . $e->getMessage());
        }
    }

    /**
     * @covers ::exception
     * @covers ::<protected>
     */
    public function testException() {
        $tester = $this->createTester();
        $exception = new \Exception('Test message', 123);
        $tester->checksScenario('Example of basic usage')
            ->expectsThat('everything works')
            ->exception($exception)
            ->hasMessage('Test message')
            ->hasCode(123);
    }

    /**
     * @covers ::boolean
     * @covers ::expectsThat
     * @covers ::<protected>
     */
    public function testBoolean() {
        $tester = $this->createTester();
        $tester->expectsThat('True is true')->boolean(true)->isTrue();
        $tester->expectsThat('True is true')->boolean(false)->isFalse();
    }

    /**
     * @covers ::theClass
     * @covers ::expectsTo
     * @covers ::<protected>
     */
    public function testTheClass() {
        $tester = $this->createTester();
        $thisClass = get_class($this);
        $tester->checksScenario('Example of basic usage')
            ->expectsThat('everything works')
            ->theClass($thisClass)
            ->isExist();
    }

    /**
     * @covers ::valueOf
     * @covers ::<protected>
     */
    public function testValueOf() {
        $tester = $this->createTester();
        $tester->valueOf(1)->isNotEmpty();
    }

    /**
     * @covers ::string
     * @covers ::<protected>
     */
    public function testString() {
        $tester = $this->createTester();
        $tester->string('')->isEmpty();
    }

    /**
     * @covers ::theArray
     * @covers ::<protected>
     */
    public function testTheArray() {
        $tester = $this->createTester();
        $tester->theArray([])->isEmpty();
    }

    /**
     * @covers ::object
     * @covers ::<protected>
     */
    public function testObject() {
        $tester = $this->createTester();
        $tester->object($this)->isNotEmpty();
    }

    /**
     * @covers ::file
     * @covers ::<protected>
     */
    public function testFile() {
        $tester = $this->createTester();
        $tester->checksScenario('Example of basic usage')
            ->expectsThat('everything works')
            ->file(__FILE__)
            ->isExist()
            ->isEqualTo(__FILE__);
    }

    /**
     * @covers ::checksScenario
     * @covers ::__destruct
     * @covers ::restoreOriginalTestName
     */
    public function testCheckSpecification() {
        $tester = new UnitTester($this);
        $tester->checksScenario('checks scenarios work');
        try {
            $tester->expectsThat('exception will be thrown')->boolean(true)->isFalse();
            $message = 'Tester failed and did not throw an exception.';
        } catch (\PHPUnit_Framework_AssertionFailedError $e) {
            $message = $e->getMessage();
        }

        $this->assertStringStartsWith('Scenario: checks scenarios work', $message);
    }

    protected function createTester() {
        return new UnitTester($this);
    }
}