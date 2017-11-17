<?php

namespace PHPKitchen\CodeSpecs\Expectation\Mixin;

/**
 * Represents a common file expectations that being used in both file and directory matchers.
 *
 * @method \PHPKitchen\CodeSpecs\Expectation\Internal\Assert startStep($stepName)
 *
 * @package PHPKitchen\CodeSpecs\Matchers\Mixins
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
trait FileStateExpectations {
    abstract public function isExist();

    abstract public function isNotExist();

    /**
     * @return $this
     */
    public function isReadable() {
        $this->isExist();
        $this->startStep('is readable')
            ->assertIsReadable();
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotReadable() {
        $this->isExist();
        $this->startStep('is not readable')
            ->assertNotIsReadable();
        return $this;
    }

    /**
     * @return $this
     */
    public function isWritable() {
        $this->isExist();
        $this->startStep('is writable')
            ->assertIsWritable();
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotWritable() {
        $this->isExist();
        $this->startStep('is not writable')
            ->assertNotIsWritable();
        return $this;
    }
}