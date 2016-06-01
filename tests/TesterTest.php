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
    /**
     * @covers ::createTester
     * @covers ::getTesterName
     */
    public function testCreate() {
        $test = new InternalTestCase();
        $tester = $test->createTester();
        $this->assertInstanceOf(UnitTester::class, $tester, 'Newly created tester should be an instance of UnitTester');
    }
}

class InternalTestCase extends \PHPUnit_Framework_TestCase {
    use Tester;
}