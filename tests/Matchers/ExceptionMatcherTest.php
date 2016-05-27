<?php

namespace Tests\Matchers;

use DeKey\Tester\Matchers\ExceptionMatcher;

/**
 * Unit test for {@link ExceptionMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\ExceptionMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class ExceptionMatcherTest extends \PHPUnit_Framework_TestCase {
    const TEST_EXCEPTION_CODE = 123;
    const TEST_EXCEPTION_MESSAGE = 'Exception for testing';
    const TEST_EXCEPTION_MESSAGE_PATTERN = '/Exception [\w]+ testing/';

    /**
     * @covers ::hasCode
     */
    public function testHasCode() {
        $matcher = $this->createMatcher();
        $matcher->hasCode(self::TEST_EXCEPTION_CODE);
    }

    /**
     * @covers ::hasMessage
     */
    public function testHasMessage() {
        $matcher = $this->createMatcher();
        $matcher->hasMessage(self::TEST_EXCEPTION_MESSAGE);
    }

    /**
     * @covers ::hasMessageMatchesPattern
     */
    public function testHasMessageMatchesPattern() {
        $matcher = $this->createMatcher();
        $matcher->hasMessageMatchesPattern(self::TEST_EXCEPTION_MESSAGE_PATTERN);
    }

    protected function createMatcher() {
        $exception = new \Exception(self::TEST_EXCEPTION_MESSAGE, self::TEST_EXCEPTION_CODE);
        return new ExceptionMatcher($exception, 'matcher does not work');
    }
}