<?php

namespace Tests\Unit\Example;

use PHPKitchen\CodeSpecs\Base\Specification;
use PHPKitchen\CodeSpecs\Contract\TestGuy;

/**
 * Specification of {@link IncomeCalculator}
 *
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class IncomeCalculatorTest extends Specification {
    private const EXPECTED_TAX_FOR_FIRST_LEVEL_TAX_RULE = 4500;
    private const EXPECTED_TAX_FOR_SECOND_LEVEL_TAX_RULE = 7200;
    private const EXPECTED_TAX_FOR_THIRD_LEVEL_TAX_RULE = 30000;
    private const INCOME_AFTER_APPLYING_FIRST_LEVEL_TAX_RULE = 300000;

    /**
     * @test
     */
    public function calculateTaxSpec() {
        $clientsPayments = []; // dummy variable, just for example
        $hoursSpentWorking = 160; // dummy variable, just for example
        $service = new IncomeCalculator($clientsPayments, $hoursSpentWorking);
        $I = $this->tester;
        $I->describe('income tax calculations');

        $I->verifyThat('income calculator honors tax rules for different ranges of income', function (TestGuy $I) use ($service) {
            $I->lookAt('income tax');

            $I->expectThat('for income less that 50 000 calculator use 10% tax rule');

            $I->seeNumber($service->calculateTax())
                ->isNotEmpty()
                ->isEqualTo(self::EXPECTED_TAX_FOR_FIRST_LEVEL_TAX_RULE);

            $I->expectThat('for income between 50 000 and 100 000 calculator use 12% tax rule');
            $I->seeNumber($service->calculateTax())
                ->isNotEmpty()
                ->isEqualTo(self::EXPECTED_TAX_FOR_SECOND_LEVEL_TAX_RULE);

            $I->expectThat('for income more than 100 000 calculator use 20% tax rule');
            $I->seeNumber('income tax', $service->calculateTax())
                ->isNotEmpty()
                ->isEqualTo(self::EXPECTED_TAX_FOR_THIRD_LEVEL_TAX_RULE);
        });
    }

    /**
     * @test
     */
    public function calculateWithTaxSpec() {
        $clientsPayments = []; // dummy variable, just for example
        $hoursSpentWorking = 160; // dummy variable, just for example
        $service = new IncomeCalculator($clientsPayments, $hoursSpentWorking);

        $I = $this->tester;
        $I->describe('income calculation');

        $I->lookAt('income tax');

        $I->expectThat('calculator calculates income with tax using 10% tax rule for income less that 50 000');

        $I->seeNumber($service->calculateWithTax())
            ->isNotEmpty()
            ->isEqualTo(self::INCOME_AFTER_APPLYING_FIRST_LEVEL_TAX_RULE);
    }
}

class IncomeCalculator {
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
