<?php

namespace Tests\Unit\Matchers;

use PHPKitchen\CodeSpecs\Expectation\Matcher\NumberMatcher;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link NumberMatcher}
 *
 * @method NumberMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\NumberMatcher
 *
 * @package Tests\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
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
            $matcherCreated = true;
        } catch (\Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . NumberMatcher::class);
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