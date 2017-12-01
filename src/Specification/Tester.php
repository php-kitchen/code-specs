<?php

namespace PHPKitchen\CodeSpecs\Specification;

use PHPKitchen\CodeSpecs\Contract\TestGuy;
use PHPKitchen\CodeSpecs\Mixin\TestGuyMethods;
use PHPUnit\Framework\Test;

/**
 * Tester is a simple class designed to make PHPUnit tests more readable using BDD-style
 * syntax. Tester represents a test-guy who is testing your code, so tests writes as a story
 * of what tester is doing. Example:
 * <pre>
 * // do stuff
 * .......
 * $I = $this->tester;
 * $I->describe('how user activates processor for PDF transformation to HTML');
 * $I->expectsThat('processor converts PDF to HTML and return HTML representation of given PDF.');
 * $I->seeString($processedContent)
 *      ->isEqualTo(self::EXPECTED_CONTENT);
 * </pre>
 *
 * @package PHPKitchen\CodeSpecs
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class Tester implements TestGuy {
    use TestGuyMethods;

    /**
     * Specifies what test guy expects from a set of matchers that would be defined next in the
     * specification.
     *
     * @param string $expectation expectation text.
     * Expectation should be a logical ending of "I expect to ". For example: "see user in the DB".
     * Such scenario would result in "I expect to see user in the DB" output in console.
     * @return $this
     */
    public function expectTo(string $expectation): TestGuy {
        $this->steps->add('I expect to ' . $expectation);
        return $this;
    }

    public function __construct(Test $test) {
        $this->context = $test;
        $this->initStepsList();
    }
}