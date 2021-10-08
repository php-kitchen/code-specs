<?php

namespace Tests\Unit\Matchers;

use Exception;
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
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class NumberMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass(): void {
        $this->matcherClass = NumberMatcher::class;
    }

    /**
     * @covers ::__construct
     */
    public function testCreate(): void {
        try {
            $this->createMatcherWithActualValue(true);
            $matcherCreated = true;
        } catch (Exception $e) {
            $matcherCreated = false;
        }
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . NumberMatcher::class);
    }

    /**
     * @covers ::isFinite
     */
    public function testIsFinite(): void {
        $number = $this->createMatcherWithActualValue(1);
        $number->isFinite();
    }

    /**
     * @covers ::isInfinite
     */
    public function testIsInfinite(): void {
        $number = $this->createMatcherWithActualValue(INF);
        $number->isInfinite();
    }

    /**
     * @covers ::isNan
     */
    public function testIsNan(): void {
        $number = $this->createMatcherWithActualValue(NAN);
        $number->isNan();
    }
}
