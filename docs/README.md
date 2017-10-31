Goal of this library is to introduce an "Actor" role in the test (like in [Codeception](https://github.com/Codeception/Codeception)) with a bunch of cool methods to "Actor" for unit testing and show a way of representing unit tests as a behavior specifications of a specific class and a test of specific method as a specification of the method.
See by yourself:
```php
use PHPKitchen\CodeSpecs\Specification\Specification;

/**
 * Specification of {@link IncomeCalculator}
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
        $clientsPayments = [];
        $hoursSpentWorking = 160;
        $service = new IncomeCalculator($clientsPayments, $hoursSpentWorking);
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
```

Tester also decorates errors output so, for example, if "IncomeCalculator" service from example above will incorrectly calculate income the error output will include following message(example of output in PHPStorm):

![picture alt](failed-test.png "Error output")

Documentation contains following paragraphs:
* [Installation](installation.md)
* [Getting started](getting-started.md)
* [Examples](examples-list.md)