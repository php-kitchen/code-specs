<?php

namespace Tests\DeKey\Tester\Unit;

use DeKey\Tester\TesterInitialization;
use DeKey\Tester\UnitTester;
use Tests\DeKey\Tester\Base\TestCase;

/**
 * Unit test for {@link Tester}
 *
 * @coversDefaultClass \DeKey\Tester\TesterInitialization
 *
 * @package Tests
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class TesterInitializationTest extends TestCase {
    use TesterInitialization;

    /**
     * @covers ::createTester
     * @covers ::getTesterName
     */
    public function testCreate() {
        $tester = $this->createTester();
        $this->assertInstanceOf(UnitTester::class, $tester, 'Newly created tester should be an instance of UnitTester');
    }

    /**
     * @covers ::initTester
     */
    public function testInit() {
        $this->assertInstanceOf(UnitTester::class, $this->tester, 'Test case should have tester initialized before test');
    }
}