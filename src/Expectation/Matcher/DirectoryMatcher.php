<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use PHPKitchen\CodeSpecs\Expectation\Matcher\Base\Matcher;

/**
 * DirectoryMatcher is designed to check given directory matches expectation.
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class DirectoryMatcher extends Matcher {
    public function isExist(): self {
        $this->startStep('is exist')
             ->assertDirectoryExists();

        return $this;
    }

    public function isNotExist(): self {
        $this->startStep('is not exist')
             ->assertDirectoryDoesNotExist();

        return $this;
    }

    public function isReadable(): self {
        $this->isExist();
        $this->startStep('is readable')
             ->assertDirectoryIsReadable();

        return $this;
    }

    public function isNotReadable(): self {
        $this->isExist();
        $this->startStep('is not readable')
             ->assertDirectoryIsNotReadable();

        return $this;
    }

    public function isWritable(): self {
        $this->isExist();
        $this->startStep('is writable')
             ->assertDirectoryIsWritable();

        return $this;
    }

    public function isNotWritable(): self {
        $this->isExist();
        $this->startStep('is not writable')
             ->assertDirectoryIsNotWritable();

        return $this;
    }
}
