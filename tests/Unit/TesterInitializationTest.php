<?php

namespace Tests\DeKey\Tester\Unit;

use DeKey\Tester\Specification\Tester;
use DeKey\Tester\TesterInitialization;
use Tests\DeKey\Tester\Base\TestCase;

/**
 * Unit test for {@link Tester}
 *
 * @coversDefaultClass \DeKey\Tester\TesterInitialization
 *
 * @package Tests
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class TesterInitializationTest extends TestCase {
    use TesterInitialization;

    /**
     * @covers ::createTester
     */
    public function testCreate() {
        $tester = $this->createTester();
        $this->assertInstanceOf(Tester::class, $tester, 'Newly created tester should be an instance of UnitTester');
    }

    /**
     * @covers ::initTester
     */
    public function testInit() {
        $this->assertInstanceOf(Tester::class, $this->tester, 'Test case should have tester initialized before test');
    }
}