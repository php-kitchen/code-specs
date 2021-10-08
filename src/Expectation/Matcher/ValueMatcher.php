<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use PHPKitchen\CodeSpecs\Expectation\Matcher\Base\Matcher;

/**
 * ValueMatcher is designed to check given value matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ValueMatcher extends Matcher {
    public function isArray(): self {
        $this->startStep('is array')
             ->assertIsArray();

        return $this;
    }

    public function isBool(): self {
        $this->startStep('is bool')
             ->assertIsBool();

        return $this;
    }

    public function isFloat(): self {
        $this->startStep('is float')
             ->assertIsFloat();

        return $this;
    }

    public function isInt(): self {
        $this->startStep('is int')
             ->assertIsInt();

        return $this;
    }

    public function isNumeric(): self {
        $this->startStep('is numeric')
             ->assertIsNumeric();

        return $this;
    }

    public function isObject(): self {
        $this->startStep('is object')
             ->assertIsObject();

        return $this;
    }

    public function isResource(): self {
        $this->startStep('is resource')
             ->assertIsResource();

        return $this;
    }

    public function isString(): self {
        $this->startStep('is string')
             ->assertIsString();

        return $this;
    }

    public function isScalar(): self {
        $this->startStep('is scalar')
             ->assertIsScalar();

        return $this;
    }

    public function isCallable(): self {
        $this->startStep('is callable')
             ->assertIsCallable();

        return $this;
    }

    public function isIterable(): self {
        $this->startStep('is iterable')
             ->assertIsIterable();

        return $this;
    }

    public function isNotArray(): self {
        $this->startStep('is array')
             ->assertIsNotArray();

        return $this;
    }

    public function isNotBool(): self {
        $this->startStep('is bool')
             ->assertIsNotBool();

        return $this;
    }

    public function isNotFloat(): self {
        $this->startStep('is float')
             ->assertIsNotFloat();

        return $this;
    }

    public function isNotInt(): self {
        $this->startStep('is int')
             ->assertIsNotInt();

        return $this;
    }

    public function isNotNumeric(): self {
        $this->startStep('is numeric')
             ->assertIsNotNumeric();

        return $this;
    }

    public function isNotObject(): self {
        $this->startStep('is object')
             ->assertIsNotObject();

        return $this;
    }

    public function isNotResource(): self {
        $this->startStep('is resource')
             ->assertIsNotResource();

        return $this;
    }

    public function isNotString(): self {
        $this->startStep('is string')
             ->assertIsNotString();

        return $this;
    }

    public function isNotScalar(): self {
        $this->startStep('is scalar')
             ->assertIsNotScalar();

        return $this;
    }

    public function isNotCallable(): self {
        $this->startStep('is callable')
             ->assertIsNotCallable();

        return $this;
    }

    public function isNotIterable(): self {
        $this->startStep('is iterable')
             ->assertIsNotIterable();

        return $this;
    }

    public function isEqualTo($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is equal to {$expectedValueName}" : "is equal to expected";

        $this->startStep($stepName)
             ->assertEquals($expected);

        return $this;
    }

    public function isEqualCanonicalizingTo($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is equal to {$expectedValueName}" : "is equal to expected";
        $stepName .= ' (canonicalizing)';
        $this->startStep($stepName)
             ->assertEqualsCanonicalizing($expected);

        return $this;
    }

    public function isEqualIgnoringCaseTo($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is equal to {$expectedValueName}" : "is equal to expected";
        $stepName .= ' (ignoring case)';
        $this->startStep($stepName)
             ->assertEqualsIgnoringCase($expected);

        return $this;
    }

    public function isEqualWithDeltaTo($expected, float $delta, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is equal to {$expectedValueName}" : "is equal to expected";
        $stepName .= ' (with delta)';
        $this->startStep($stepName)
             ->assertEqualsWithDelta($expected, $delta);

        return $this;
    }

    public function isNotEqualTo($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is not equal to {$expectedValueName}" : "is not equal to expected";
        $this->startStep($stepName)
             ->assertNotEquals($expected);

        return $this;
    }

    public function isNotEqualCanonicalizingTo($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is not equal to {$expectedValueName}" : "is not equal to expected";
        $stepName .= ' (canonicalizing)';
        $this->startStep($stepName)
             ->assertNotEqualsCanonicalizing($expected);

        return $this;
    }

    public function isNotEqualIgnoringCaseTo($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is not equal to {$expectedValueName}" : "is not equal to expected";
        $stepName .= ' (ignoring case)';
        $this->startStep($stepName)
             ->assertNotEqualsIgnoringCase($expected);

        return $this;
    }

    public function isNotEqualWithDeltaTo($expected, float $delta, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is not equal to {$expectedValueName}" : "is not equal to expected";
        $stepName .= ' (with delta)';
        $this->startStep($stepName)
             ->assertNotEqualsWithDelta($expected, $delta);

        return $this;
    }

    public function isGreaterThan($expected): self {
        $this->startStep('is greater than "' . $expected . '"')
             ->assertGreaterThan($expected);

        return $this;
    }

    public function isLessThan($expected): self {
        $this->startStep('is less than "' . $expected . '"')
             ->assertLessThan($expected);

        return $this;
    }

    public function isGreaterOrEqualTo($expected): self {
        $this->startStep('is greater or equal to "' . $expected . '"')
             ->assertGreaterThanOrEqual($expected);

        return $this;
    }

    public function isLessOrEqualTo($expected): self {
        $this->startStep('is less or equal to "' . $expected . '"')
             ->assertLessThanOrEqual($expected);

        return $this;
    }

    public function isNull(): self {
        $this->startStep('is null')
             ->assertNull();

        return $this;
    }

    public function isNotNull(): self {
        $this->startStep('is not null')
             ->assertNotNull();

        return $this;
    }

    public function isEmpty(): self {
        $this->startStep('is empty')
             ->assertEmpty();

        return $this;
    }

    public function isNotEmpty(): self {
        $this->startStep('is not empty')
             ->assertNotEmpty();

        return $this;
    }

    public function isTheSameAs($expected, $expectedValueName = ''): self {
        $stepName = $expectedValueName ? "is the same as {$expectedValueName}" : "is the same as expected";
        $this->startStep($stepName)
             ->assertSame($expected);

        return $this;
    }

    public function isNotTheSameAs($expected, $expectedValueName = ''): ValueMatcher {
        $stepName = $expectedValueName ? "is not the same as {$expectedValueName}" : "is not the same as expected";

        $this->startStep($stepName)
             ->assertNotSame($expected);

        return $this;
    }
}
