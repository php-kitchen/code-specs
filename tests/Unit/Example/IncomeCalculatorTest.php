<?php

namespace Tests\Unit\Example;

use DeKey\Tester\Specification\Specification;

/**
 * Specification of {@link IncomeService}
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class IncomeCalculatorTest extends Specification {
    private const EXPECTED_TAX_FOR_FIRST_LEVEL_TAX_RULE = 4500;
    private const EXPECTED_TAX_FOR_SECOND_LEVEL_TAX_RULE = 7200;
    private const EXPECTED_TAX_FOR_THIRD_LEVEL_TAX_RULE = 30000;

    /**
     * @test
     */
    public function calculateTaxSpec() {
        $this->markTestSkipped();
        $clientsPayments = [];
        $hoursSpentWorking = 160;
        $service = new IncomeService($clientsPayments, $hoursSpentWorking);
        $I = $this->tester;
        $I->describe('income tax calculations');

        $I->verifyThat('income calculator honors tax rules for different ranges of income');

        $I->expectThat('for income less that 50 000 calculator use 10% tax rule');
        $I->seeThatNumber('income tax', $service->calculateTax())
            ->isNotEmpty()
            ->isEqualTo(self::EXPECTED_TAX_FOR_FIRST_LEVEL_TAX_RULE);

        $I->expectThat('for income between 50 000 and 100 000 calculator use 12% tax rule');
        $I->seeThatNumber('income tax', $service->calculateTax())
            ->isNotEmpty()
            ->isEqualTo(self::EXPECTED_TAX_FOR_SECOND_LEVEL_TAX_RULE);

        $I->expectThat('for income more than 100 000 calculator use 20% tax rule');
        $I->seeThatNumber('income tax', $service->calculateTax())
            ->isNotEmpty()
            ->isEqualTo(self::EXPECTED_TAX_FOR_THIRD_LEVEL_TAX_RULE);
    }
}

class IncomeService {
    public function __construct($clientsPayments, $workingHours) {
    }

    public function calculateWithoutTax() {
        return 478;
    }

    public function calculateWithTax() {
        return 478;
    }

    public function calculateTax() {
        return 4500;
    }
}