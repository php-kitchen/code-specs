<?php

namespace DeKey\Tester\Matchers;

/**
 * StringMatcher is designed to check given string matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class StringMatcher extends ValueMatcher {
    public function isJson() {
        $this->registerExpectation('is JSON');
        $this->test->assertJson($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToJsonFile($file) {
        $this->registerExpectation('is equal to JSON file "' . $file . '"');
        $this->test->assertJsonStringEqualsJsonFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToJsonFile($file) {
        $this->registerExpectation('is not equal to JSON file "' . $file . '"');
        $this->test->assertJsonStringNotEqualsJsonFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToJsonString($string) {
        $this->registerExpectation('is equal to JSON string "' . $string . '"');
        $this->test->assertJsonStringEqualsJsonString($string, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToJsonString($string) {
        $this->registerExpectation('is not equal to JSON string "' . $string . '"');
        $this->test->assertJsonStringNotEqualsJsonString($string, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToFile($file) {
        $this->registerExpectation('is equal to file "' . $file . '"');
        $this->test->assertStringEqualsFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToFile($file) {
        $this->registerExpectation('is not equal to file "' . $file . '"');
        $this->test->assertStringNotEqualsFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToXmlFile($file) {
        $this->registerExpectation('is equal to XML file "' . $file . '"');
        $this->test->assertXmlStringEqualsXmlFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToXmlFile($file) {
        $this->registerExpectation('is not equal to XML file "' . $file . '"');
        $this->test->assertXmlStringNotEqualsXmlFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToXmlString($xmlString) {
        $this->registerExpectation('is equal to XML string "' . $xmlString . '"');
        $this->test->assertXmlStringEqualsXmlString($xmlString, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToXmlString($xmlString) {
        $this->registerExpectation('is not equal to XML string "' . $xmlString . '"');
        $this->test->assertXmlStringNotEqualsXmlString($xmlString, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function startsWith($prefix) {
        $this->registerExpectation('starts with "' . $prefix . '"');
        $this->test->assertStringStartsWith($prefix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotStartWith($prefix) {
        $this->registerExpectation('does not start with "' . $prefix . '"');
        $this->test->assertStringStartsNotWith($prefix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function endsWith($suffix) {
        $this->registerExpectation('ends with "' . $suffix . '"');
        $this->test->assertStringEndsWith($suffix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotEndWith($suffix) {
        $this->registerExpectation('does not end with "' . $suffix . '"');
        $this->test->assertStringEndsNotWith($suffix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function matchesRegExp($expression) {
        $this->registerExpectation('matches regular expression "' . $expression . '"');
        $this->test->assertRegExp($expression, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function matchesFormat($format) {
        $this->registerExpectation('matches format "' . $format . '"');
        $this->test->assertStringMatchesFormat($format, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotMatchFormat($format) {
        $this->registerExpectation('does not match format "' . $format . '"');
        $this->test->assertStringNotMatchesFormat($format, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function matchesFormatFromFile($formatFile) {
        $this->registerExpectation('matches format from file "' . $formatFile . '"');
        $this->test->assertStringMatchesFormatFile($formatFile, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotMatchFormatFromFile($formatFile) {
        $this->registerExpectation('does not match format from file "' . $formatFile . '"');
        $this->test->assertStringNotMatchesFormatFile($formatFile, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function contains($needle) {
        $this->registerExpectation('contains "' . $needle . '"');
        $this->test->assertContains($needle, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotContain($needle) {
        $this->registerExpectation('does not contain "' . $needle . '"');
        $this->test->assertNotContains($needle, $this->actual, $this->getMessageForAssert());
        return $this;
    }
}