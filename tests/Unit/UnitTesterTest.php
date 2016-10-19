<?php

namespace Tests\DeKey\Tester\Unit;

use DeKey\Tester\TesterExpectation;
use DeKey\Tester\UnitTester;
use Tests\DeKey\Tester\Base\TestCase;

/**
 * Unit test for {@link UnitTester}
 *
 * @coversDefaultClass \DeKey\Tester\UnitTester
 *
 * @package Tests
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class UnitTesterTest extends TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        $mock = $this->createMock(TestCase::class);
        try {
            (new UnitTester($mock));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate UnitTester. Error message is: ' . $e->getMessage());
        }
    }

    /**
     * @covers ::checksScenario
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

    /**
     * @covers ::expectsThat
     * @covers ::createExpectation
     */
    public function testExpectsThat() {
        $tester = new UnitTester($this);
        $expectation = $tester->expectsThat('expectation being created');

        $this->assertInstanceOf(TesterExpectation::class, $expectation, 'Expected that tester returns new expectation object if "expectsThat" method being called.');
    }

    /**
     * @covers ::expectsTo
     * @covers ::createExpectation
     */
    public function testExpectsRo() {
        $tester = new UnitTester($this);
        $expectation = $tester->expectsTo('expectation being created');

        $this->assertInstanceOf(TesterExpectation::class, $expectation, 'Expected that tester returns new expectation object if "expectsTo" method being called.');
    }

    protected function createTester() {
        return new UnitTester($this);
    }
}