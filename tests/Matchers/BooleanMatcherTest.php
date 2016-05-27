<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\BooleanMatcher;

/**
 * Unit test for {@link BooleanMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\BooleanMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class BooleanMatcherTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new BooleanMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . BooleanMatcher::class);
        }
    }

    /**
     * @covers ::isTrue
     */
    public function testIsTrue() {
        $matcher = $this->createMatcherWithActualValue(true);
        $matcher->isTrue();
    }

    /**
     * @covers ::isFalse
     */
    public function testIsFalse() {
        $matcher = $this->createMatcherWithActualValue(false);
        $matcher->isFalse();
    }

    protected function createMatcherWithActualValue($value) {
        return new BooleanMatcher($value, 'matcher does not work');
    }
}