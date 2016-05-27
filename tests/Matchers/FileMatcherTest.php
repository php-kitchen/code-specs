<?php
namespace Tests\Matchers;

use DeKey\Tester\Matchers\FileMatcher;

/**
 * Unit test for {@link FileMatcher}
 *
 * @coversDefaultClass \DeKey\Tester\Matchers\FileMatcher
 *
 * @package Tests\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class FileMatcherTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers ::__construct
     */
    public function testCreate() {
        try {
            (new FileMatcher('', ''));
        } catch (\Exception $e) {
            $this->fail('Unable to instantiate ' . FileMatcher::class);
        }
    }

    protected function createMatcherWithActualValue($value) {
        return new FileMatcher($value, 'matcher does not work');
    }
}