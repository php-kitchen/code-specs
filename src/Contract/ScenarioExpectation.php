<?php
namespace DeKey\Tester\Contract;

/**
 * Represents expectation of a tests scenario. Defines basic interface for any expectations.
 * Any custom expectations should implement this interface.
 *
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
interface ScenarioExpectation {
    /**
     * Returns an instance of test invoked expectation.
     *
     * @return \PHPUnit\Framework\TestCase
     */
    public function getTest();
}