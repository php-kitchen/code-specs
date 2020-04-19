<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use PHPKitchen\CodeSpecs\Expectation\Matcher\Base\Matcher;
use PHPKitchen\CodeSpecs\Expectation\Mixin\FileStateExpectations;

/**
 * FileMatcher is designed to check given file matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class FileMatcher extends Matcher {
    use FileStateExpectations;

    /**
     * @return $this
     */
    public function isExist(): self {
        $this->startStep('is exist')
             ->assertFileExists();

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotExist(): self {
        $this->startStep('is not exist')
             ->assertFileNotExists();

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualTo($file): self {
        $this->startStep('is equal to file "' . $file . '"')
             ->assertFileEquals($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualTo($file): self {
        $this->startStep('is not equal to file "' . $file . '"')
             ->assertFileNotEquals($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualToJsonFile($file): self {
        $this->startStep('is equal to json file "' . $file . '"')
             ->assertJsonFileEqualsJsonFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualToJsonFile($file): self {
        $this->startStep('is not equal to json file "' . $file . '"')
             ->assertJsonFileNotEqualsJsonFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualToXmlFile($file): self {
        $this->startStep('is equal to xml file "' . $file . '"')
             ->assertXmlFileEqualsXmlFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualToXmlFile($file): self {
        $this->startStep('is not equal to xml file "' . $file . '"')
             ->assertXmlFileNotEqualsXmlFile($file);

        return $this;
    }
}