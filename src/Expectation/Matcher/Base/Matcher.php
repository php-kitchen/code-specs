<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher\Base;

use PHPKitchen\CodeSpecs\Contract\ExpectationMatcher;
use PHPKitchen\CodeSpecs\Expectation\Internal\Assert;

/**
 * Matcher is a base class for all of the expectation matchers.
 *
 * @package PHPKitchen\CodeSpecs\Base
 * @author Dima Kolodko <dima@kolodko.pro>
 */
abstract class Matcher implements ExpectationMatcher {
    private $assert;

    public function __construct(Assert $assert) {
        $this->assert = $assert;
    }

    public function __clone() {
        $this->assert = clone $this->assert;
    }

    protected function startStep($stepName) {
        $this->assert->changeCurrentStepTo($stepName);

        return $this->assert;
    }

    public function __invoke($actualValue) {
        $newMatcher = clone $this;

        $newMatcher->assert->switchToInTimeExecutionStrategy();
        $newMatcher->assert->runStepsWithActualValue($actualValue);

        return $newMatcher;
    }

    protected function createInternalMatcherWithDescription($matcherClass, $description) {
        $assert = clone $this->assert;
        $assert->changeDescriptionTo($description);

        return new $matcherClass($assert);
    }

    protected function getActualValue() {
        return $this->assert->getActualValue();
    }
}