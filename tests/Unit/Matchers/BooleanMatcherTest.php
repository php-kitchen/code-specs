<?php

namespace Tests\Unit\Matchers;

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
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class BooleanMatcherTest extends BaseMatcherTest {
    protected function initMatcherClass() {
        $this->matcherClass = BooleanMatcher::class;
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
        $this->assertTrue($matcherCreated, 'Unable to instantiate ' . BooleanMatcher::class);
    }

    /**
     * @covers ::isTrue
     */
    public function testIsTrue() {
        $bool = $this->createMatcherWithActualValue(true);
        $bool->isTrue();
    }

    /**
     * @covers ::isFalse
     */
    public function testIsFalse() {
        $bool = $this->createMatcherWithActualValue(false);
        $bool->isFalse();
    }

    /**
     * @covers ::isNotTrue
     */
    public function testIsNotTrue() {
        $bool = $this->createMatcherWithActualValue(1);
        $bool->isNotTrue();
    }

    /**
     * @covers ::isNotFalse
     */
    public function testIsNotFalse() {
        $bool = $this->createMatcherWithActualValue(0);
        $bool->isNotFalse();
    }
}