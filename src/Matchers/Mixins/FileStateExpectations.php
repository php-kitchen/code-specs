<?php

namespace DeKey\Tester\Matchers\Mixins;

/**
 * Represents
 *
 * @package DeKey\Tester\Matchers\Mixins
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
trait FileStateExpectations {
    abstract public function isExist(): self;

    abstract public function isNotExist(): self;

    public function isReadable(): self {
        $this->registerExpectation('is readable');
        $this->isExist();
        $this->test->assertIsReadable($this->actual, $this->description);
        return $this;
    }

    public function isNotReadable(): self {
        $this->registerExpectation('is not readable');
        $this->isExist();
        $this->test->assertNotIsReadable($this->actual, $this->description);
        return $this;
    }

    public function isWritable(): self {
        $this->registerExpectation('is writable');
        $this->isExist();
        $this->test->assertIsWritable($this->actual, $this->description);
        return $this;
    }

    public function isNotWritable(): self {
        $this->registerExpectation('is not writable');
        $this->isExist();
        $this->test->assertNotIsWritable($this->actual, $this->description);
        return $this;
    }
}