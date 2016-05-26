<?php

namespace DeKey\Tester;

/**
 * Tester adds support of {@link UnitTester} in PHPUnit test cases.
 *
 * @package DeKey\Tester
 * @author Dmitry Kolodko <dangel@quartsoft.com>
 */
trait Tester {
    /**
     * @return UnitTester tester instance.
     */
    public function createTester() {
        return new UnitTester($this, $this->getTesterName());
    }

    /**
     * Override to specify custom na for the tester.
     * For example you can name you tester "Alex", "Vova" or "World Destroyer 5697".
     *
     * @return string {@link UnitTester} name.
     */
    protected function getTesterName() {
        return 'Tester';
    }
}