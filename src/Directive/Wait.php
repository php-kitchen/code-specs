<?php

namespace PHPKitchen\CodeSpecs\Directive;

use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;

/**
 * Represents a helper that allows to wait with a specified convention.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class Wait {
    private const MICROSECOND_MULTIPLIER = 1;
    private const MILLISECOND_MULTIPLIER = 100000;
    private const SECOND_MULTIPLIER = 1000000;
    private const MINUTE_MULTIPLIER = 60000000;
    private int $timeToWait;
    private StepsList $steps;

    public function __construct(int $timeToWait, StepsList $stepsList) {
        $this->timeToWait = $timeToWait;
        $this->steps = $stepsList;
    }

    public function microseconds() {
        $this->wait('seconds', self::MICROSECOND_MULTIPLIER);
    }

    public function milliseconds() {
        $this->wait('seconds', self::MILLISECOND_MULTIPLIER);
    }

    public function seconds() {
        $this->wait('seconds', self::SECOND_MULTIPLIER);
    }

    public function minutes() {
        $this->wait('minutes', self::MINUTE_MULTIPLIER);
    }

    protected function wait($unitOfTime, $multiplier) {
        $this->steps->add("I wait {$this->timeToWait} {$unitOfTime}");

        usleep($this->timeToWait * $multiplier);
    }
}