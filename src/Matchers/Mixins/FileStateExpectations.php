<?php

namespace DeKey\Tester\Matchers\Mixins;

/**
 * Represents
 *
 * @package DeKey\Tester\Matchers\Mixins
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
trait FileStateExpectations {
    abstract public function isExist();

    abstract public function isNotExist();

    public function isReadable() {
        $this->registerExpectation('is readable');
        $this->isExist();
        $this->test->assertIsReadable($this->actual, $this->description);
        return $this;
    }

    public function isNotReadable() {
        $this->registerExpectation('is not readable');
        $this->isExist();
        $this->test->assertNotIsReadable($this->actual, $this->description);
        return $this;
    }

    public function isWritable() {
        $this->registerExpectation('is writable');
        $this->isExist();
        $this->test->assertIsWritable($this->actual, $this->description);
        return $this;
    }

    public function isNotWritable() {
        $this->registerExpectation('is not writable');
        $this->isExist();
        $this->test->assertNotIsWritable($this->actual, $this->description);
        return $this;
    }
}