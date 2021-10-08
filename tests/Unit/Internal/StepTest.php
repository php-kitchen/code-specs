<?php

namespace Tests\Unit\Internal;

use PHPKitchen\CodeSpecs\Expectation\Internal\Step;
use Tests\Base\TestCase;

/**
 * Unit test for {@link Step}
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Internal\Step
 *
 * @package Test\Internal
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class StepTest extends TestCase {
    /**
     * @covers ::toString
     * @covers ::__toString
     */
    public function testToStringUnchecked(): void {
        $uncheckedStep = new Step('dummy step');
        $stepString = $uncheckedStep->toString();
        $this->assertEquals('[-] dummy step', $stepString, 'Step should be converted to a string with "-" sign at the beginning to identify that step has not passed');
    }

    /**
     * @covers ::check
     * @covers ::toString
     * @covers ::__toString
     * @covers ::isChecked
     */
    public function testToStringChecked(): void {
        $checkedStep = new Step('dummy step');
        $checkedStep->check();
        $stepString = $checkedStep->toString();
        $this->assertEquals("[✓] dummy step", $stepString, 'Step should be converted to a string with "✓" sign at the beginning to identify that step has not passed');
    }
}
