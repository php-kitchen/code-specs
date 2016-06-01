<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Base\Matcher;
use PHPUnit_Framework_Assert as Assert;

/**
 * FileMatcher is designed to check given file matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko
 */
class FileMatcher extends Matcher {
    public function isExist() {
        Assert::assertFileExists($this->actual, $this->description);
        return $this;
    }

    public function isNotExist() {
        Assert::assertFileNotExists($this->actual, $this->description);
        return $this;
    }

    public function isEqualTo($file) {
        Assert::assertFileEquals($file, $this->actual, $this->description);
        return $this;
    }

    public function isNotEqualTo($file) {
        Assert::assertFileNotEquals($file, $this->actual, $this->description);
        return $this;
    }

    public function isEqualToJsonFile($file) {
        Assert::assertJsonFileEqualsJsonFile($file, $this->actual, $this->description);
        return $this;
    }

    public function isNotEqualToJsonFile($file) {
        Assert::assertJsonFileNotEqualsJsonFile($file, $this->actual, $this->description);
        return $this;
    }
}