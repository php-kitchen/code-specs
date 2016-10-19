<?php
namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Matchers\BooleanMatcher;
use Tests\DeKey\Tester\Base\BaseMatcherTest;

/**
 * Unit test for {@link BooleanMatcher}
 *
 * @method BooleanMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\BooleanMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
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
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . BooleanMatcher::class);
        }
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