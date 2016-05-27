<?php

namespace Tests\Proxy;

use DeKey\Tester\Base\Matcher;
use DeKey\Tester\Proxy\AssertionsFailureCatcher;

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
     * @covers ::callMatcherMethod
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
     * @covers ::executeMethodIfPublic
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
     * @covers ::addFailureException
     */
    public function testCallThrowsException() {
        // Catcher should catch exception thrown in matcher and add to test result
        $catcher = $this->getMockBuilder(AssertionsFailureCatcher::class)
            ->setMethods(['addFailureException'])
            ->setConstructorArgs([$this, new TestMatcher('', '')])
            ->getMock();
        $catcher->expects($this->once())->method('addFailureException');

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