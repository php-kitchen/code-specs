<?php

namespace PHPKitchen\CodeSpecs\Specification;

use PHPKitchen\CodeSpecsCore\Expectation\Matcher\ArrayMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\BooleanMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\ClassMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\DirectoryMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\FileMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\NumberMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\ObjectMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\StringMatcher;
use PHPKitchen\CodeSpecsCore\Expectation\Matcher\ValueMatcher;

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
 * $I->seeThatString($processedContent)
 *      ->isEqualTo(self::EXPECTED_CONTENT);
 * </pre>
 *
 * @deprecated use {@link Tester} instead. This class would be removed in next major update.
 *
 * @package PHPKitchen\CodeSpecs
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class OldTester extends Tester {
    //region ----------------------- SPECIFICATION METHODS -----------------------
    public function seeThatValueOf(...$params): ValueMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->see($variable);
    }

    public function seeThatString(...$params): StringMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->seeString($variable);
    }

    public function seeThatArray(...$params): ArrayMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->seeArray($variable);
    }

    public function seeThatBoolean(...$params): BooleanMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->seeBool($variable);
    }

    public function seeThatNumber(...$params): NumberMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->seeNumber($variable);
    }

    public function seeThatObject(...$params): ObjectMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->seeObject($variable);
    }

    public function seeThatClass(...$params): ClassMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->seeClass($variable);
    }

    public function seeThatFile(...$params): FileMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);
        return $this->seeFile($variable);
    }

    public function seeThatDirectory(...$params): DirectoryMatcher {
        $variable = $this->parseVariableAndSetNameFromParams($params);

        return $this->seeDirectory($variable);
    }

    protected function parseVariableAndSetNameFromParams(array $params) {
        if (count($params) >= 2) {
            [$variableName, $variable] = $params;
        } elseif (count($params) == 1) {
            $variable = $params[0];
            $variableName = null;
        } else {
            throw new \InvalidArgumentException();
        }
        if ($variableName) {
            $this->variableName = $variableName;
        }
        return $variable;
    }
    //endregion
}