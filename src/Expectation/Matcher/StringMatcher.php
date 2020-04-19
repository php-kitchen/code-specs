<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

/**
 * StringMatcher is designed to check given string matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class StringMatcher extends ValueMatcher {
    /**
     * @return $this
     */
    public function isJson(): self {
        $this->startStep('is JSON')
             ->assertJson();

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualToJsonFile($file): self {
        $this->startStep('is equal to JSON file "' . $file . '"')
             ->assertJsonStringEqualsJsonFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualToJsonFile($file): self {
        $this->startStep('is not equal to JSON file "' . $file . '"')
             ->assertJsonStringNotEqualsJsonFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualToJsonString($string): self {
        $this->startStep('is equal to JSON string "' . $string . '"')
             ->assertJsonStringEqualsJsonString($string);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualToJsonString($string): self {
        $this->startStep('is not equal to JSON string "' . $string . '"')
             ->assertJsonStringNotEqualsJsonString($string);

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualToFile($file): self {
        $this->startStep('is equal to file "' . $file . '"')
             ->assertStringEqualsFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualToFile($file): self {
        $this->startStep('is not equal to file "' . $file . '"')
             ->assertStringNotEqualsFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualToXmlFile($file): self {
        $this->startStep('is equal to XML file "' . $file . '"')
             ->assertXmlStringEqualsXmlFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualToXmlFile($file): self {
        $this->startStep('is not equal to XML file "' . $file . '"')
             ->assertXmlStringNotEqualsXmlFile($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function isEqualToXmlString($xmlString): self {
        $this->startStep('is equal to XML string "' . $xmlString . '"')
             ->assertXmlStringEqualsXmlString($xmlString);

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotEqualToXmlString($xmlString): self {
        $this->startStep('is not equal to XML string "' . $xmlString . '"')
             ->assertXmlStringNotEqualsXmlString($xmlString);

        return $this;
    }

    /**
     * @return $this
     */
    public function startsWith($prefix): self {
        $this->startStep('starts with "' . $prefix . '"')
             ->assertStringStartsWith($prefix);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotStartWith($prefix): self {
        $this->startStep('does not start with "' . $prefix . '"')
             ->assertStringStartsNotWith($prefix);

        return $this;
    }

    /**
     * @return $this
     */
    public function endsWith($suffix): self {
        $this->startStep('ends with "' . $suffix . '"')
             ->assertStringEndsWith($suffix);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotEndWith($suffix): self {
        $this->startStep('does not end with "' . $suffix . '"')
             ->assertStringEndsNotWith($suffix);

        return $this;
    }

    /**
     * @return $this
     */
    public function matchesRegExp($expression): self {
        $this->startStep('matches regular expression "' . $expression . '"')
             ->assertRegExp($expression);

        return $this;
    }

    /**
     * @return $this
     */
    public function matchesFormat($format): self {
        $this->startStep('matches format "' . $format . '"')
             ->assertStringMatchesFormat($format);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotMatchFormat($format): self {
        $this->startStep('does not match format "' . $format . '"')
             ->assertStringNotMatchesFormat($format);

        return $this;
    }

    /**
     * @return $this
     */
    public function matchesFormatFromFile($formatFile): self {
        $this->startStep('matches format from file "' . $formatFile . '"')
             ->assertStringMatchesFormatFile($formatFile);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotMatchFormatFromFile($formatFile): self {
        $this->startStep('does not match format from file "' . $formatFile . '"')
             ->assertStringNotMatchesFormatFile($formatFile);

        return $this;
    }

    /**
     * @return $this
     */
    public function contains($needle): self {
        $this->startStep('contains "' . $needle . '"')
             ->assertContains($needle);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotContain($needle): self {
        $this->startStep('does not contain "' . $needle . '"')
             ->assertNotContains($needle);

        return $this;
    }
}