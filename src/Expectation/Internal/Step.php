<?php

namespace PHPKitchen\CodeSpecs\Expectation\Internal;

/**
 * Represents assert step of each expectaion.
 * Calling any if matcher assert methods produce new instance of this class.
 *
 * @package PHPKitchen\CodeSpecs\Module
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class Step {
    /**
     * @var string name of the step that would be used in error output.
     */
    private $name;
    /**
     * @var bool identifies whether step successfully passed or not.
     * Based on this value output of the step  would contain checked or not checked sigh.
     */
    private $checked = false;

    public function __construct($name) {
        $this->name = $name;
    }

    public function check() {
        $this->checked = true;
    }

    public function __toString() {
        return $this->toString();
    }

    public function toString() {
        $stepResult = $this->isChecked() ? "\u{2713} " : '- ';
        return $stepResult . $this->name;
    }

    protected function isChecked() {
        return $this->checked;
    }
}