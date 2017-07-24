<?php

namespace DeKey\Tester\Matchers;

/**
 * StringMatcher is designed to check given string matches expectation.
 *
 * @package DeKey\Tester\Matchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class StringMatcher extends ValueMatcher {
    public function isJson(): self {
        $this->registerExpectation('is JSON');
        $this->test->assertJson($this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToJsonFile($file): self {
        $this->registerExpectation('is equal to JSON file "' . $file . '"');
        $this->test->assertJsonStringEqualsJsonFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToJsonFile($file): self {
        $this->registerExpectation('is not equal to JSON file "' . $file . '"');
        $this->test->assertJsonStringNotEqualsJsonFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToJsonString($string): self {
        $this->registerExpectation('is equal to JSON string "' . $string . '"');
        $this->test->assertJsonStringEqualsJsonString($string, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToJsonString($string): self {
        $this->registerExpectation('is not equal to JSON string "' . $string . '"');
        $this->test->assertJsonStringNotEqualsJsonString($string, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToFile($file): self {
        $this->registerExpectation('is equal to file "' . $file . '"');
        $this->test->assertStringEqualsFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToFile($file): self {
        $this->registerExpectation('is not equal to file "' . $file . '"');
        $this->test->assertStringNotEqualsFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToXmlFile($file): self {
        $this->registerExpectation('is equal to XML file "' . $file . '"');
        $this->test->assertXmlStringEqualsXmlFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToXmlFile($file): self {
        $this->registerExpectation('is not equal to XML file "' . $file . '"');
        $this->test->assertXmlStringNotEqualsXmlFile($file, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isEqualToXmlString($xmlString): self {
        $this->registerExpectation('is equal to XML string "' . $xmlString . '"');
        $this->test->assertXmlStringEqualsXmlString($xmlString, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function isNotEqualToXmlString($xmlString): self {
        $this->registerExpectation('is not equal to XML string "' . $xmlString . '"');
        $this->test->assertXmlStringNotEqualsXmlString($xmlString, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function startsWith($prefix): self {
        $this->registerExpectation('starts with "' . $prefix . '"');
        $this->test->assertStringStartsWith($prefix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotStartWith($prefix): self {
        $this->registerExpectation('does not start with "' . $prefix . '"');
        $this->test->assertStringStartsNotWith($prefix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function endsWith($suffix): self {
        $this->registerExpectation('ends with "' . $suffix . '"');
        $this->test->assertStringEndsWith($suffix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotEndWith($suffix): self {
        $this->registerExpectation('does not end with "' . $suffix . '"');
        $this->test->assertStringEndsNotWith($suffix, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function matchesRegExp($expression): self {
        $this->registerExpectation('matches regular expression "' . $expression . '"');
        $this->test->assertRegExp($expression, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function matchesFormat($format): self {
        $this->registerExpectation('matches format "' . $format . '"');
        $this->test->assertStringMatchesFormat($format, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotMatchFormat($format): self {
        $this->registerExpectation('does not match format "' . $format . '"');
        $this->test->assertStringNotMatchesFormat($format, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function matchesFormatFromFile($formatFile): self {
        $this->registerExpectation('matches format from file "' . $formatFile . '"');
        $this->test->assertStringMatchesFormatFile($formatFile, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotMatchFormatFromFile($formatFile): self {
        $this->registerExpectation('does not match format from file "' . $formatFile . '"');
        $this->test->assertStringNotMatchesFormatFile($formatFile, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function contains($needle): self {
        $this->registerExpectation('contains "' . $needle . '"');
        $this->test->assertContains($needle, $this->actual, $this->getMessageForAssert());
        return $this;
    }

    public function doesNotContain($needle): self {
        $this->registerExpectation('does not contain "' . $needle . '"');
        $this->test->assertNotContains($needle, $this->actual, $this->getMessageForAssert());
        return $this;
    }
}