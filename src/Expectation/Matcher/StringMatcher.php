<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * StringMatcher is designed to check given string matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class StringMatcher extends ValueMatcher {
    public function isJson(): self {
        $this->startStep('is JSON')
             ->assertJson();

        return $this;
    }

    public function isEqualToJsonFile(string $file): self {
        $this->startStep('is equal to JSON file "' . $file . '"')
             ->assertJsonStringEqualsJsonFile($file);

        return $this;
    }

    public function isNotEqualToJsonFile(string $file): self {
        $this->startStep('is not equal to JSON file "' . $file . '"')
             ->assertJsonStringNotEqualsJsonFile($file);

        return $this;
    }

    public function isEqualToJsonString(string $string): self {
        $this->startStep('is equal to JSON string "' . $string . '"')
             ->assertJsonStringEqualsJsonString($string);

        return $this;
    }

    public function isNotEqualToJsonString(string $string): self {
        $this->startStep('is not equal to JSON string "' . $string . '"')
             ->assertJsonStringNotEqualsJsonString($string);

        return $this;
    }

    public function isEqualToFile(string $file): self {
        $this->startStep('is equal to file "' . $file . '"')
             ->assertStringEqualsFile($file);

        return $this;
    }

    public function isEqualsToFileCanonicalizing(string $file): self {
        $this->startStep('is equal to file "' . $file . '" (canonicalizing)')
             ->assertStringEqualsFileCanonicalizing($file);

        return $this;
    }

    public function isEqualsToFileIgnoringCase(string $file): self {
        $this->startStep('is equal to file "' . $file . '" (ignoring case)')
             ->assertStringEqualsFileIgnoringCase($file);

        return $this;
    }

    public function isNotEqualToFile(string $file): self {
        $this->startStep('is not equal to file "' . $file . '"')
             ->assertStringNotEqualsFile($file);

        return $this;
    }

    public function isNotEqualsToFileCanonicalizing(string $file): self {
        $this->startStep('is not equal to file "' . $file . '" (canonicalizing)')
             ->assertStringNotEqualsFileCanonicalizing($file);

        return $this;
    }

    public function isNotEqualsToFileIgnoringCase(string $file): self {
        $this->startStep('is not equal to file "' . $file . '" (ignoring case)')
             ->assertStringNotEqualsFileIgnoringCase($file);

        return $this;
    }

    public function isEqualToXmlFile(string $file): self {
        $this->startStep('is equal to XML file "' . $file . '"')
             ->assertXmlStringEqualsXmlFile($file);

        return $this;
    }

    public function isNotEqualToXmlFile(string $file): self {
        $this->startStep('is not equal to XML file "' . $file . '"')
             ->assertXmlStringNotEqualsXmlFile($file);

        return $this;
    }

    public function isEqualToXmlString(string $xmlString): self {
        $this->startStep('is equal to XML string "' . $xmlString . '"')
             ->assertXmlStringEqualsXmlString($xmlString);

        return $this;
    }

    public function isNotEqualToXmlString(string $xmlString): self {
        $this->startStep('is not equal to XML string "' . $xmlString . '"')
             ->assertXmlStringNotEqualsXmlString($xmlString);

        return $this;
    }

    public function startsWith(string $prefix): self {
        $this->startStep('starts with "' . $prefix . '"')
             ->assertStringStartsWith($prefix);

        return $this;
    }

    public function doesNotStartWith(string $prefix): self {
        $this->startStep('does not start with "' . $prefix . '"')
             ->assertStringStartsNotWith($prefix);

        return $this;
    }

    public function endsWith(string $suffix): self {
        $this->startStep('ends with "' . $suffix . '"')
             ->assertStringEndsWith($suffix);

        return $this;
    }

    public function doesNotEndWith(string $suffix): self {
        $this->startStep('does not end with "' . $suffix . '"')
             ->assertStringEndsNotWith($suffix);

        return $this;
    }

    public function matchesRegExp(string $expression): self {
        $this->startStep('matches regular expression "' . $expression . '"')
             ->assertRegExp($expression);

        return $this;
    }

    public function matchesFormat(string $format): self {
        $this->startStep('matches format "' . $format . '"')
             ->assertStringMatchesFormat($format);

        return $this;
    }

    public function doesNotMatchFormat(string $format): self {
        $this->startStep('does not match format "' . $format . '"')
             ->assertStringNotMatchesFormat($format);

        return $this;
    }

    public function matchesFormatFromFile(string $formatFile): self {
        $this->startStep('matches format from file "' . $formatFile . '"')
             ->assertStringMatchesFormatFile($formatFile);

        return $this;
    }

    public function doesNotMatchFormatFromFile(string $formatFile): self {
        $this->startStep('does not match format from file "' . $formatFile . '"')
             ->assertStringNotMatchesFormatFile($formatFile);

        return $this;
    }

    /**
     * @param string $needle
     *
     * @return $this
     * @deprecated Use containsString() or containsStringIgnoringCase() instead
     */
    public function contains(string $needle): self {
        $this->startStep('contains "' . $needle . '"')
             ->assertContains($needle);

        return $this;
    }

    /**
     * @param string $needle
     *
     * @return $this
     * @deprecated Use containsString() or containsStringIgnoringCase() instead
     */
    public function doesNotContain(string $needle): self {
        $this->startStep('does not contain "' . $needle . '"')
             ->assertNotContains($needle);

        return $this;
    }

    public function containsString(string $needle): self {
        $this->startStep('contains "' . $needle . '" string')
             ->assertStringContainsString($needle);

        return $this;
    }

    public function doesNotContainsString(string $needle): self {
        $this->startStep('does not contains "' . $needle . '" string')
             ->assertStringNotContainsString($needle);

        return $this;
    }

    public function containsStringIgnoringCase(string $needle): self {
        $this->startStep('contains "' . $needle . '" string ignoring case')
             ->assertStringContainsStringIgnoringCase($needle);

        return $this;
    }

    public function doesNotContainsStringIgnoringCase(string $needle): self {
        $this->startStep('does not contains "' . $needle . '" string ignoring case')
             ->assertStringNotContainsStringIgnoringCase($needle);

        return $this;
    }
}
