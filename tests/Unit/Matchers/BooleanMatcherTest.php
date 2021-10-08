<?php

namespace Tests\Unit\Matchers;

use Exception;
use PHPKitchen\CodeSpecs\Expectation\Matcher\BooleanMatcher;
use Tests\Base\BaseMatcherTest;

/**
 * Unit test for {@link BooleanMatcher}
 *
 * @method BooleanMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Matcher\BooleanMatcher
 *
 * @package Tests\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class BooleanMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass(): void {
        $this->matcherClass = BooleanMatcher::class;
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
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . BooleanMatcher::class);
    }

    /**
     * @covers ::isTrue
     */
    public function testIsTrue(): void {
        $bool = $this->createMatcherWithActualValue(true);
        $bool->isTrue();
    }

    /**
     * @covers ::isFalse
     */
    public function testIsFalse(): void {
        $bool = $this->createMatcherWithActualValue(false);
        $bool->isFalse();
    }

    /**
     * @covers ::isNotTrue
     */
    public function testIsNotTrue(): void {
        $bool = $this->createMatcherWithActualValue(1);
        $bool->isNotTrue();
    }

    /**
     * @covers ::isNotFalse
     */
    public function testIsNotFalse(): void {
        $bool = $this->createMatcherWithActualValue(0);
        $bool->isNotFalse();
    }
}
