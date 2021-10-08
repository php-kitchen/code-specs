<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use PHPKitchen\CodeSpecs\Expectation\Matcher\Base\Matcher;

/**
 * FileMatcher is designed to check given file matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class FileMatcher extends Matcher {
    public function isExist(): self {
        $this->startStep('is exist')
             ->assertFileExists();

        return $this;
    }

    public function isNotExist(): self {
        $this->startStep('is not exist')
             ->assertFileDoesNotExist();

        return $this;
    }

    public function isReadable(): self {
        $this->isExist();
        $this->startStep('is readable')
             ->assertIsReadable();

        return $this;
    }

    public function isNotReadable(): self {
        $this->isExist();
        $this->startStep('is not readable')
             ->assertIsNotReadable();

        return $this;
    }

    public function isWritable(): self {
        $this->isExist();
        $this->startStep('is writable')
             ->assertIsWritable();

        return $this;
    }

    public function isNotWritable(): self {
        $this->isExist();
        $this->startStep('is not writable')
             ->assertIsNotWritable();

        return $this;
    }

    public function isEqualTo(string $file): self {
        $this->startStep('is equal to file "' . $file . '"')
             ->assertFileEquals($file);

        return $this;
    }

    public function isEqualCanonicalizingTo(string $file): self {
        $this->startStep('is equal to file "' . $file . '" (canonicalizing)')
             ->assertFileEqualsCanonicalizing($file);

        return $this;
    }

    public function isEqualIgnoringCaseTo(string $file): self {
        $this->startStep('is equal to file "' . $file . '" (ignoring case)')
             ->assertFileEqualsIgnoringCase($file);

        return $this;
    }

    public function isNotEqualTo(string $file): self {
        $this->startStep('is not equal to file "' . $file . '"')
             ->assertFileNotEquals($file);

        return $this;
    }

    public function isNotEqualCanonicalizingTo(string $file): self {
        $this->startStep('is not equal to file "' . $file . '" (canonicalizing)')
             ->assertFileNotEqualsCanonicalizing($file);

        return $this;
    }

    public function isNotEqualIgnoringCaseTo(string $file): self {
        $this->startStep('is not equal to file "' . $file . '" (ignoring case)')
             ->assertFileNotEqualsIgnoringCase($file);

        return $this;
    }

    public function isEqualToJsonFile(string $file): self {
        $this->startStep('is equal to json file "' . $file . '"')
             ->assertJsonFileEqualsJsonFile($file);

        return $this;
    }

    public function isNotEqualToJsonFile(string $file): self {
        $this->startStep('is not equal to json file "' . $file . '"')
             ->assertJsonFileNotEqualsJsonFile($file);

        return $this;
    }

    public function isEqualToXmlFile(string $file): self {
        $this->startStep('is equal to xml file "' . $file . '"')
             ->assertXmlFileEqualsXmlFile($file);

        return $this;
    }

    public function isNotEqualToXmlFile(string $file): self {
        $this->startStep('is not equal to xml file "' . $file . '"')
             ->assertXmlFileNotEqualsXmlFile($file);

        return $this;
    }
}
