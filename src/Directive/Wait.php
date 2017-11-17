<?php

namespace PHPKitchen\CodeSpecs\Directive;

use PHPKitchen\CodeSpecs\Expectation\Internal\StepsList;

/**
 * Represents a helper that allows to wait with a specified convention.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class Wait {
    private $microSecondMultiplier = 1;
    private $milliSecondMultiplier = 100000;
    private $secondMultiplier = 1000000;
    private $minuteMultiplier = 60000000;
    private $timeToWait;
    private $steps;

    public function __construct(int $timeToWait, StepsList $stepsList) {
        $this->timeToWait = $timeToWait;
        $this->steps = $stepsList;
    }

    public function microseconds() {
        $this->wait('seconds', $this->microSecondMultiplier);
    }

    public function milliseconds() {
        $this->wait('seconds', $this->milliSecondMultiplier);
    }

    public function seconds() {
        $this->wait('seconds', $this->secondMultiplier);
    }

    public function minutes() {
        $this->wait('minutes', $this->minuteMultiplier);
    }

    protected function wait($unitOfTime, $multiplier) {
        $this->steps->add("I wait {$this->timeToWait} {$unitOfTime}");

        usleep($this->timeToWait * $multiplier);
    }
}