<?php

namespace PHPKitchen\CodeSpecs\Expectation\Internal;

/**
 * Represents a list of steps performed during a specification.
 *
 * @package PHPKitchen\CodeSpecs\Expectation\Internal
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class StepsList {
    /**
     * @var Step[] steps storage.
     */
    private $steps = [];
    private static $instance;

    public static function getInstance(): self {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function add(string $step) {
        $lastStep = end($this->steps);
        if ($lastStep) {
            $lastStep->check();
        }
        $this->steps[] = new Step($step);
    }

    public function convertToString(): string {
        $message = implode(PHP_EOL, $this->steps);
        $message = $message ? $message . PHP_EOL : $message;

        return (string)$message;
    }

    public function clear() {
        $this->steps = [];
    }
}