<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Matchers\Base\Matcher;
use DeKey\Tester\Matchers\Mixins\FileStateExpectations;

/**
 * DirectoryMatcher is designed to check given directory matches expectation.
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class DirectoryMatcher extends Matcher {
    use FileStateExpectations;

    public function isExist(): self {
        $this->registerExpectation('is exist');
        $this->test->assertDirectoryExists($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotExist(): self {
        $this->registerExpectation('is not exist');
        $this->test->assertDirectoryNotExists($this->actual, $this->getMessageForAssert());
        return $this;
    }
}