<?php
namespace DeKey\Tester\Contract;

/**
 * Represents a test-guy who is testing your code, so tests writes as a story of what tester is doing.
 *
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
interface TestGuy {
    /**
     * Specifies scenario Tester working on.
     * Scenario will be displayed in the error output if a test fails.
     *
     * @param string $scenario text representation of scenario tester will check.
     * @return $this
     */
    public function checksScenario($scenario);

    /**
     * Starts a chain of expectations.
     *
     * @param string $expectation text representation of expectation.
     * @return ScenarioExpectation expectation instance.
     */
    public function expectsThat($expectation = '');

    /**
     * Starts a chain of expectations.
     *
     * @param string $expectation text representation of expectation.
     * @return ScenarioExpectation expectation instance.
     */
    public function expectsTo($expectation = '');
}