<?php
namespace Tests\DeKey\Tester\Unit\Matchers;

use DeKey\Tester\Base\Matcher;
use DeKey\Tester\TesterExpectation;
use DeKey\Tester\Matchers\ObjectMatcher;
use Tests\DeKey\Tester\Base\TestCase;

/**
 * Unit test for {@link Matcher}
 *
 * @method ObjectMatcher createMatcherWithActualValue($actualValue)
 *
 * @coversDefaultClass \DeKey\Tester\Base\Matcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class MatcherTest extends TestCase {
    protected $expectationObject;

    /**
     * @covers ::that
     */
    public function testThat() {
        $matcher = $this->createMatcher();
        $result = $matcher->that();
        $this->assertEquals($matcher, $result, 'Matcher should return itself if "that" helper method being called.');
    }

    /**
     * @covers ::__call
     */
    public function testAnd() {
        $matcher = $this->createMatcher();
        $result = $matcher->and();
        $this->assertEquals($this->getExpectationObject(), $result, 'Matcher should return expectation if "and" helper method being called.');
    }

    /**
     * @covers ::__call
     */
    public function testMissingMethod() {
        $this->expectException(\BadMethodCallException::class);
        $matcher = $this->createMatcher();
        $result = $matcher->notExistingMethod();
    }

    /**
     * @return Matcher
     */
    protected function createMatcher() {
        return new StubMatcher($this->getExpectationObject(), '', '');
    }

    protected function getExpectationObject() {
        if ($this->expectationObject === null) {
            $this->expectationObject = new TesterExpectation($this);
        }
        return $this->expectationObject;
    }
}

class StubMatcher extends Matcher {
}