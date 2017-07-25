<?php

namespace DeKey\Tester\Matchers;

use DeKey\Tester\Matchers\Base\Matcher;
use DeKey\Tester\Matchers\Mixins\FileStateExpectations;

/**
 * FileMatcher is designed to check given file matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class FileMatcher extends Matcher {
    use FileStateExpectations;

    public function isExist() {
        $this->registerExpectation('is exist');
        $this->test->assertFileExists($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotExist() {
        $this->registerExpectation('is not exist');
        $this->test->assertFileNotExists($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualTo($file) {
        $this->registerExpectation('is equal to file "' . $file . '"');
        $this->test->assertFileEquals($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualTo($file) {
        $this->registerExpectation('is not equal to file "' . $file . '"');
        $this->test->assertFileNotEquals($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToJsonFile($file) {
        $this->registerExpectation('is equal to json file "' . $file . '"');
        $this->test->assertJsonFileEqualsJsonFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToJsonFile($file) {
        $this->registerExpectation('is not equal to json file "' . $file . '"');
        $this->test->assertJsonFileNotEqualsJsonFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToXmlFile($file) {
        $this->registerExpectation('is equal to xml file "' . $file . '"');
        $this->test->assertXmlFileEqualsXmlFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToXmlFile($file) {
        $this->registerExpectation('is not equal to xml file "' . $file . '"');
        $this->test->assertXmlFileNotEqualsXmlFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }
}