<?php

namespace Tests;

use DeKey\Tester\Tester;
use DeKey\Tester\UnitTester;

/**
 * Unit test for {@link Tester}
 *
 * @coversDefaultClass \DeKey\Tester\Tester
 *
 * @package Tests
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class TesterTest extends \PHPUnit_Framework_TestCase {
    use Tester;

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