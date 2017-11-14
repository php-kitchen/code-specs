<?php

namespace Tests\Unit;

use PHPKitchen\CodeSpecs\Mixin\TesterInitialization;
use PHPKitchen\CodeSpecs\Specification\Tester;
use Tests\Base\TestCase;

/**
 * Unit test for {@link Tester}
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Mixin\TesterInitialization
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