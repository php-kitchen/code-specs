<?php

namespace Tests\Internal;

use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;
use Tests\Base\TestCase;

/**
 * Unit test for {@link StepsList}
 *
 * @coversDefaultClass \PHPKitchen\CodeSpecs\Expectation\Internal\StepsList
 *
 * @package Test\Internal
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class StepsTest extends TestCase {
    /**
     * @covers ::add
     * @covers ::convertToString
     * @covers ::getInstance
     */
    public function testAdd() {
        $list = $this->createListWithTwoSteps();
        $stepsListString = $list->convertToString();
        $expectedStepsStringRepresentation = "✓ checked step\n- un-checked step\n";

        $this->assertEquals($expectedStepsStringRepresentation, $stepsListString, 'Steps list should mark all of the steps prior to the last one as checked');
    }

    /**
     * @covers ::clear
     */
    public function testClear() {
        $list = $this->createListWithTwoSteps();

        $list->clear();

        $stepsListString = $list->convertToString();
        $this->assertEquals('', $stepsListString);
    }

    protected function createListWithTwoSteps(): StepsList {
        $list = StepsList::getInstance();
        $list->add('checked step');
        $list->add('un-checked step');

        return $list;
    }
}