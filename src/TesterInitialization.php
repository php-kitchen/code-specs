<?php
namespace DeKey\Tester;

/**
 * Adds support of {@link UnitTester} in PHPUnit test classes.
 *
 * @package DeKey\Tester
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
trait TesterInitialization {
    /**
     * @var UnitTester instance of tester. This property refreshing before each test.
     */
    public $tester;

    /**
     * @before
     */
    public function initTester() {
        $this->tester = $this->createTester();
    }

    /**
     * Creates tester instance before each test.
     * Override to specify custom tester or do other stuff you want.
     *
     * @return UnitTester tester instance.
     */
    public function createTester() {
        return new UnitTester($this, $this->getTesterName(), $this->getExpectationClass());
    }

    /**
     * Override to specify custom name for the tester.
     * For example you can name you tester as "Alex", "Vova" or "World Destroyer 5697".
     * Changing tester name have no impact on library functionality, you can change tester name just fot fun.
     *
     * @return string {@link UnitTester} name.
     */
    protected function getTesterName() {
        return 'Tester';
    }

    /**
     * Override to specify custom expectation class for the tester.
     * Custom expectation should implement {@link \DeKey\Tester\Contract\ScenarioExpectation}
     *
     * @return string existing expectation class.
     */
    protected function getExpectationClass() {
        return TesterExpectation::class;
    }
}