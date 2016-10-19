Goal of this library is to introduce "Tester" role to PHPUnit tests. Tester is responsible for verification of correct results so any asserts being made by tester and not by test. To achieve the goal of a readable tests all of the assertions being build by tester as as chained method calls with a readable self explained method names. Example:

```php
public function testCalculateIncome() {
        $tester = $this->tester;
        $service = new IncomeService();
        $tester->checksScenario('service calculates income to the system.')
            ->expectsThat('calculated income matches expected income.')
            ->valueOf($service->calculateIncome())
            ->isEqualTo(self::EXPECTED_INCOME);
}
```

Tester also decorates errors output so, for example, if "IncomeService" service from example above will incorrectly calculate income the error output will include following message(example of output in PHPStorm):

![picture alt](error-output.png "Error output")

Documentation contains following paragraphs:
* [Installation](installation.md)
* [Getting started](getting-started.md)
* [Examples](examples-list.md)
* [Personalization](personalization.md)