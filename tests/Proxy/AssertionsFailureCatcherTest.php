<?php

namespace Tests\Proxy;

use DeKey\Tester\Base\Matcher;
use DeKey\Tester\Proxy\AssertionsFailureCatcher;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;

/**
 * Unit test for {@link AssertionsFailureCatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Proxy\AssertionsFailureCatcher
 *
 * @package Tests\Proxy
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class AssertionsFailureCatcherTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            $this->createCatcher();
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . AssertionsFailureCatcher::class . '. Error message: ' . $e->getMessage());
        }
    }

    /**
     * @covers ::__call
     * @covers ::proxyMethodCallToMatcher
     * @covers ::executeMethodIfPublic
     * @covers ::callMatcherMethod
     * @covers ::<protected>
     */
    public function testCallToPublicMethod() {
        $catcher = $this->createCatcher();

        try {
            $result = $catcher->returnTrue();
        } catch (\Exception $e) {
            $this->fail("Catcher can't proxy call to public matcher's method. Error message: " . $e->getMessage());
        }
        $this->assertTrue($result, 'Call to "returnTrue" of a test matcher should return "true".');
    }

    /**
     * @covers ::__call
     * @covers ::proxyMethodCallToMatcher
     * @covers ::executeMethodIfPublic
     * @covers ::throwExceptionWithMessage
     * @covers ::<protected>
     */
    public function testCallToProtectedMethod() {
        // Catcher should not allow access to protected or private methods
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/Trying to access not public method [\w]+ of [\w\/]+/');
        $catcher = $this->createCatcher();
        $catcher->returnFalse();
    }

    /**
     * @covers ::__call
     * @covers ::proxyMethodCallToMatcher
     * @covers ::throwExceptionWithMessage
     * @covers ::<protected>
     */
    public function testCallToNotExistedMethod() {
        // Catcher should not allow access to protected or private methods
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/[\w\/]+::callNotExtisted does not exist!/');
        $catcher = $this->createCatcher();
        $catcher->callNotExtisted();
    }

    /**
     * @covers ::__call
     * @covers ::proxyMethodCallToMatcher
     * @covers ::addFailureException
     * @covers ::<protected>
     */
    public function testCallThrowsException() {
        // Catcher should catch exception thrown in matcher and add to test result
        $test = $this->getMockBuilder(\PHPUnit_Framework_TestCase::class)
            ->setMethods(['getTestResultObject'])
            ->getMock();
        $test->expects($this->once())->method('getTestResultObject')->willReturn(new TestResultBuilder());
        $catcher = new AssertionsFailureCatcher($test, new TestMatcher('', ''));

        $catcher->throwException();
    }

    protected function createCatcher() {
        return new AssertionsFailureCatcher($this, new TestMatcher('', ''));
    }
}

class TestMatcher extends Matcher {
    public function returnTrue() {
        return true;
    }

    protected function returnFalse() {
        return true;
    }

    public function throwException() {
        throw new \Exception('Exception that should be cached!');
        return true;
    }
}

/**
 * Result builder that checks AssertionsFailureCatcher adds exception expected to be thrown by {@link TestMatcher::throwException}
 */
class TestResultBuilder extends \PHPUnit_Framework_TestResult {
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time) {
        $expectedError = new \PHPUnit_Framework_AssertionFailedError('Exception that should be cached!');
        \PHPUnit_Framework_Assert::assertEquals($expectedError->getMessage(), $e->getMessage());
    }
}