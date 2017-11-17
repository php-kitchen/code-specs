<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use PHPKitchen\CodeSpecs\Expectation\Matcher\Base\Matcher;

/**
 * ValueMatcher is designed to check given value matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ValueMatcher extends Matcher {
    /**
     * @return $this
     */
    public function isInternalType($type): self {
        $this->startStep('is internal type "' . $type . '"')
            ->assertInternalType($type);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotInternalType($type): self {
        $this->startStep('is not internal type "' . $type . '"')
            ->assertNotInternalType($type);
        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualTo($expected, $expectedValueName = '') {
        $stepName = $expectedValueName ? "is equal to {$expectedValueName}" : "is equal to expected";

        $this->startStep($stepName)
            ->assertEquals($expected);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualTo($expected, $expectedValueName = '') {
        $stepName = $expectedValueName ? "is not equal to {$expectedValueName}" : "is not equal to expected";
        $this->startStep($stepName)
            ->assertNotEquals($expected);
        return $this;
    }

    /**
     * @return $this
     */
    public function isGreaterThan($expected): self {
        $this->startStep('is greater than "' . $expected . '"')
            ->assertGreaterThan($expected);
        return $this;
    }

    /**
     * @return $this
     */
    public function isLessThan($expected): self {
        $this->startStep('is less than "' . $expected . '"')
            ->assertLessThan($expected);
        return $this;
    }

    /**
     * @return $this
     */
    public function isGreaterOrEqualTo($expected): self {
        $this->startStep('is greater or equal to "' . $expected . '"')
            ->assertGreaterThanOrEqual($expected);
        return $this;
    }

    /**
     * @return $this
     */
    public function isLessOrEqualTo($expected): self {
        $this->startStep('is less or equal to "' . $expected . '"')
            ->assertLessThanOrEqual($expected);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNull(): self {
        $this->startStep('is null')
            ->assertNull();
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotNull(): self {
        $this->startStep('is not null')
            ->assertNotNull();
        return $this;
    }

    /**
     * @return $this
     */
    public function isEmpty(): self {
        $this->startStep('is empty')
            ->assertEmpty();
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEmpty(): self {
        $this->startStep('is not empty')
            ->assertNotEmpty();
        return $this;
    }

    /**
     * @return $this
     */
    public function isTheSameAs($expected, $expectedValueName = '') {
        $stepName = $expectedValueName ? "is the same as {$expectedValueName}" : "is the same as expected";
        $this->startStep($stepName)
            ->assertSame($expected);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotTheSameAs($expected, $expectedValueName = '') {
        $stepName = $expectedValueName ? "is not the same as {$expectedValueName}" : "is not the same as expected";

        $this->startStep($stepName)
            ->assertNotSame($expected);
        return $this;
    }
}