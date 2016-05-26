<?php

namespace Tests;

use DeKey\Tester\UnitTester;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for {@link UnitTester}
 *
 * @coversDefaultClass \dekey\tester\UnitTester
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

    public function testException() {
        $tester = new UnitTester($this);
        $exception = new \Exception('Test message', 123);
        $tester->exception($exception)->hasMessage('Test message')->hasCode(123);
    }

    public function testBoolean() {
        $tester = new UnitTester($this);
        $tester->expectsThat('True is true')->boolean(true)->isTrue();
        $tester->expectsThat('True is true')->boolean(false)->isFalse();
    }

    public function testClass() {
        $tester = new UnitTester($this);
        $thisClass = get_class($this);
        $tester->expectsThat('True is true')->theClass($thisClass)->isExist();
    }
}