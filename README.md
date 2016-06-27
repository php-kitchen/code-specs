# PHPUnit Tester

Build information: [![Build Status](https://travis-ci.org/dekeysoft/pu-tester.svg?branch=master)](https://travis-ci.org/dekeysoft/pu-tester)
[![Coverage Status](https://coveralls.io/repos/github/dekeysoft/pu-tester/badge.svg?branch=master)](https://coveralls.io/github/dekeysoft/pu-tester?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dekeysoft/pu-tester/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dekeysoft/pu-tester/?branch=master)

Releases: [![Latest Stable Version](https://poser.pugx.org/dekeysoft/pu-tester/v/stable)](https://packagist.org/packages/dekeysoft/pu-tester)
[![Latest Unstable Version](https://poser.pugx.org/dekeysoft/pu-tester/v/unstable)](https://packagist.org/packages/dekeysoft/pu-tester)
[![Total Downloads](https://poser.pugx.org/dekeysoft/pu-tester/downloads)](https://packagist.org/packages/dekeysoft/pu-tester)

Licensing: [![License](https://poser.pugx.org/dekeysoft/pu-tester/license)](https://github.com/dekeysoft/pu-tester/blob/master/LICENSE)

BDD style tester for PHPUnit that allows to writes test in readable format. Goal of this library is to introduce "Tester" role to PHPUnit tests. Tester is responsible for verification of correct results so any asserts being made by tester and not by test. To achive the goal of a readable tests all of the assertions being build by tester as as chained method calls with a readable self explained method names. Example:
```php
public function testCalculateIncome() {
        $tester = $this->createTester();
        $service = new IncomeService();
        $tester->checksScenario('Service calculates income to the system.')
            ->expectsThat('calculated income matches expected income.')
            ->valueOf($service->calculateIncome())
            ->isEqualTo(self::EXPECTED_INCOME);
}
```

PHPUnit Tester also decorates errors output so, for example, if "IncomeService" service from example above will incorrectly calculate income the eror output will include follwoing message: "Tester expects that calculated income matches expected income." and scenario would be concatinated to the test name and output as "testCalculateIncome | Service calculates income to the system."

## Requirements

**`>=PHP5.6.0` is required.**

## Getting Started

Run the following to add PHPUnit Tester to your project's `composer.json`. See [Packagist](https://packagist.org/packages/dekeysoft/pu-tester) for specific versions.

```bash
composer require dekeysoft/pu-tester
```

Then you can use PHPUnit Tester in your test simply by using "Tester" trait in your test case. Example:
```php
class TestCase extends \PHPUnit_Framework_TestCase {
    use \DeKey\Tester\Tester;

    public function testSomeMethod() {
        $tester = $this->createTester();
        ......
    }
}
```

For additional information and guides go to the [project Wiki](https://github.com/dekeysoft/pu-tester/wiki)
