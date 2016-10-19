<?php
namespace DeKey\Tester\Matchers;

use DeKey\Tester\Base\Matcher;
use PHPUnit_Framework_Assert as Assert;

/**
 * DirectoryMatcher is designed to check given directory matches expectation.
 *
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class DirectoryMatcher extends Matcher {
    public function isExist() {
        Assert::assertDirectoryExists($this->actual, $this->description);
        return $this;
    }

    public function isNotExist() {
        Assert::assertDirectoryNotExists($this->actual, $this->description);
        return $this;
    }

    public function isReadable() {
        $this->isExist();
        Assert::assertIsReadable($this->actual, $this->description);
        return $this;
    }

    public function isNotReadable() {
        $this->isExist();
        Assert::assertNotIsReadable($this->actual, $this->description);
        return $this;
    }

    public function isWritable() {
        $this->isExist();
        Assert::assertIsWritable($this->actual, $this->description);
        return $this;
    }

    public function isNotWritable() {
        $this->isExist();
        Assert::assertNotIsWritable($this->actual, $this->description);
        return $this;
    }
}