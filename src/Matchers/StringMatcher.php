<?php

namespace DeKey\Tester\Matchers;

use PHPUnit_Framework_Assert as Assert;

/**
 * StringMatcher is designed to check given string matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
class StringMatcher extends ValueMatcher {
    public function isEqualsJsonFile($file) {
        Assert::assertJsonStringEqualsJsonFile($file, $this->actual, $this->description);
        return $this;
    }

    public function isEqualsJsonString($string) {
        Assert::assertJsonStringEqualsJsonString($string, $this->actual, $this->description);
        return $this;
    }

    public function isEqualToFile($file) {
        Assert::assertStringEqualsFile($file, $this->actual, $this->description);
        return $this;
    }

    public function isNotEqualToFile($file) {
        Assert::assertStringNotEqualsFile($file, $this->actual, $this->description);
        return $this;
    }

    public function isEqualToXmlFile($file) {
        Assert::assertXmlStringEqualsXmlFile($file, $this->actual, $this->description);
        return $this;
    }

    public function isEqualToXmlString($xmlString) {
        Assert::assertXmlStringEqualsXmlString($xmlString, $this->actual, $this->description);
        return $this;
    }

    public function isEqualToXMLStructure($xml, $checkAttributes = false) {
        Assert::assertEqualXMLStructure($xml, $this->actual, $checkAttributes, $this->description);
        return $this;
    }

    public function startsWith($prefix) {
        Assert::assertStringStartsWith($prefix, $this->actual, $this->description);
        return $this;
    }

    public function doesNotStartWith($prefix) {
        Assert::assertStringStartsNotWith($prefix, $this->actual, $this->description);
        return $this;
    }

    public function endsWith($suffix) {
        Assert::assertStringEndsWith($suffix, $this->actual, $this->description);
        return $this;
    }

    public function doesNotEndWith($suffix) {
        Assert::assertStringEndsNotWith($suffix, $this->actual, $this->description);
        return $this;
    }

    public function matchesRegExp($expression) {
        Assert::assertRegExp($expression, $this->actual, $this->description);
        return $this;
    }

    public function matchesFormat($format) {
        Assert::assertStringMatchesFormat($format, $this->actual, $this->description);
        return $this;
    }

    public function doesNotMatchFormat($format) {
        Assert::assertStringNotMatchesFormat($format, $this->actual, $this->description);
        return $this;
    }

    public function matchesFormatFromFile($formatFile) {
        Assert::assertStringMatchesFormatFile($formatFile, $this->actual, $this->description);
        return $this;
    }

    public function doesNotMatchFormatFromFile($formatFile) {
        Assert::assertStringNotMatchesFormatFile($formatFile, $this->actual, $this->description);
        return $this;
    }

    public function contains($needle) {
        Assert::assertContains($needle, $this->actual, $this->description);
        return $this;
    }

    public function doesNotContain($needle) {
        Assert::assertNotContains($needle, $this->actual, $this->description);
        return $this;
    }
}