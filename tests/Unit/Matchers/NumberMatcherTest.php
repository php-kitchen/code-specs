<?php
namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Matchers\NumberMatcher;
use Tests\DeKey\Tester\Base\BaseMatcherTest;

/**
 * Unit test for {@link NumberMatcher}
 *
 * @method NumberMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\NumberMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class NumberMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = NumberMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createMatcherWithActualValue(true);
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . NumberMatcher::class);
        }
    }

    /**
     * @covers ::isFinite
     */
    public function testIsFinite() {
        $number = $this->createMatcherWithActualValue(1);
        $number->isFinite();
    }

    /**
     * @covers ::isInfinite
     */
    public function testIsInfinite() {
        $number = $this->createMatcherWithActualValue(INF);
        $number->isInfinite();
    }

    /**
     * @covers ::isNan
     */
    public function testIsNan() {
        $number = $this->createMatcherWithActualValue(NAN);
        $number->isNan();
    }
}