<p align="center">
    <img src="https://github.com/php-kitchen/code-specs/blob/master/docs/logo.png" width="600px">
</p>

<p align="center">
    <a href="https://travis-ci.org/php-kitchen/code-specs"><img src="https://travis-ci.org/php-kitchen/code-specs.svg?branch=master" alt="Build Status"></a>
    <a href="https://coveralls.io/github/php-kitchen/code-specs?branch=master"><img src="https://coveralls.io/repos/github/php-kitchen/code-specs/badge.svg?branch=master" alt="Code Coverage"></a>
    <a href="https://scrutinizer-ci.com/g/php-kitchen/code-specs/?branch=master"><img src="https://scrutinizer-ci.com/g/php-kitchen/code-specs/badges/quality-score.png?b=master" alt="Code Quality"></a>
    <a href="https://packagist.org/packages/php-kitchen/code-specs"><img src="https://poser.pugx.org/php-kitchen/code-specs/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/php-kitchen/code-specs"><img src="https://poser.pugx.org/php-kitchen/code-specs/d/monthly" alt="Monthly Downloads"></a>
    <a href="https://packagist.org/packages/php-kitchen/code-specs"><img src="https://poser.pugx.org/php-kitchen/code-specs/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/php-kitchen/code-specs"><img src="https://poser.pugx.org/php-kitchen/code-specs/license.svg" alt="License"></a>
</p>

Code Specs isn't just another tests library - it's the way you design your soultions. The Specs Way.

Code Specs is built as a PHPUnit plugin(with Codeception support aswell) for writing BDD style Unit tests in a specification way using human-readable format. 

Goal of Code Specs is to add a bunch of cool tools for unit testing and show a way of representing unit tests as a behavior specifications that describes specific class behavior in variety of use-cases.

The min hero of Code Specs that does the magic is Tester. Tester represents an actor who ensures you code pass specifications(yes, like in [Codeception](https://github.com/Codeception/Codeception) - this library expired by Codeception). See iy by yourself:
```php
namespace Specs\Unit;

use PHPKitchen\CodeSpecs\Base\Specification;
use PHPKitchen\CodeSpecs\Contract\TestGuy;

/**
 * Specification of {@link IncomeCalculator}
 *
 * @author Dima Kolodko <prowwid@gmail.com>
 */
class IncomeCalculatorTest extends Specification {
    private const EXPECTED_TAX_FOR_FIRST_LEVEL_TAX_RULE = 4500;
    private const EXPECTED_TAX_FOR_SECOND_LEVEL_TAX_RULE = 7200;
    private const EXPECTED_TAX_FOR_THIRD_LEVEL_TAX_RULE = 30000;
    private const INCOME_AFTER_APPLYING_FIRST_LEVEL_TAX_RULE = 300000;

    /**
     * @test
     */
    public function calculateTaxBehavior() {
        $clientsPayments = []; // dummy variable, just for example
        $hoursSpentWorking = 160; // dummy variable, just for example
        $service = new IncomeCalculator($clientsPayments, $hoursSpentWorking);
        $I = $this->tester;
        $I->describe('income tax calculations');

        $I->verifyThat('income calculator honors tax rules for different ranges of income', function (TestGuy $I) use ($service) {

            $I->expectThat('for income less that 50 000 calculator use 10% tax rule');
            $I->lookAt('first level income tax');
            $I->seeNumber($service->calculateTax())
                ->isNotEmpty()
                ->isEqualTo(self::EXPECTED_TAX_FOR_FIRST_LEVEL_TAX_RULE);

            $I->expectThat('for income between 50 000 and 100 000 calculator use 12% tax rule');
            $I->lookAt('second level income tax');
            $I->seeNumber($service->calculateTax())
                ->isNotEmpty()
                ->isEqualTo(self::EXPECTED_TAX_FOR_SECOND_LEVEL_TAX_RULE);

            $I->expectThat('for income more than 100 000 calculator use 20% tax rule');
            $I->lookAt('third level income tax');
            $I->seeNumber('income tax', $service->calculateTax())
                ->isNotEmpty()
                ->isEqualTo(self::EXPECTED_TAX_FOR_THIRD_LEVEL_TAX_RULE);
        });
    }

    /**
     * @test
     */
    public function calculateWithTaxBehavior() {
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
```

CodeSpecs also decorates errors output so, for example, if "IncomeCalculator" service from example above will incorrectly calculate income the error output will include following message(example of output in PHPStorm):

![picture alt](docs/en/failed-spec.png "Error output")

## Requirements

**`PHP >= 7.1` is required.**

**`PHPUnit >= 6.0` is required but `PHPUnit >= 6.2` is recommended.**

## Getting Started

Run the following command to add CodeSpecs to your project's `composer.json`. See [Packagist](https://packagist.org/packages/php-kitchen/code-specs) for specific versions.

```bash
composer require --dev php-kitchen/code-specs
```

Or you can copy this library from:
- [Packagist](https://packagist.org/packages/php-kitchen/code-specs)
- [Github](https://github.com/php-kitchen/code-specs)

Then you can use CodeSpecs in your test simply extending from `Specification` class. Example:
```php
use PHPKitchen\CodeSpecs\Base\Specification;

class YourTest extends Specification {

    /**
     * @test
     */
    public function myMethodBehavior() {
        $I = $this->tester;
        ......
        $I->lookAt('my dummy variable');
        $I->seeBool(true)->isFalse();
    }
}

```

or by using "TesterInitialization" trait in your test case

```php
use PHPUnit\Framework\TestCase;
use PHPKitchen\CodeSpecs\Mixin\TesterInitialization;

class YourTest extends TestCase {
    use TesterInitialization;

    /**
     * @test
     */
    public function myMethodBehavior() {
        $I = $this->tester;
        ......
        $I->lookAt('my dummy variable');
        $I->seeBool(true)->isFalse();
    }
}
```
**Note:** *If you want to use CodeSpecs with Codeception read [Codeception integration guide](docs/en/integrations/codeception.md)*

For additional information and guides go to the [project documentation](docs/README.md)
See [changes log](docs/CHANGELOG.md) for information about changes in releases and [update guide](docs/UPDATE-GUIDE.md) for information about upgrading to a next major version.

## Contributing

If you want to ask any questions, suggest improvements or just to talk with community and developers, [join our server at Discord](https://discord.gg/Ez5VZhC) 
Read [organization contributing rules](https://github.com/php-kitchen/conventions/blob/master/CONTRIBUTING.md) for additional information.

### Spreading the Word

Acknowledging or citing CodeSpecs is as important as direct contributions.

If you are using CodeSpecs as part of an OpenSource project, a way to acknowledge it is to use a special badge in your README:
<a href="https://github.com/php-kitchen/code-specs"><img src="https://img.shields.io/badge/Tested%20%20By-CodeSpecs-brightgreen.svg" alt="Tested By"></a>

If your code is hosted at GitHub, you can place the following in your README.md file to get the badge:
```markdown
[![CodeSpecs](https://img.shields.io/badge/Tested_By-CodeSpecs-brightgreen.svg?style=flat)](https://github.com/php-kitchen/code-specs)
```
or use regular HTML:
```markdown
<a href="https://github.com/php-kitchen/code-specs"><img src="https://img.shields.io/badge/Tested_By-CodeSpecs-brightgreen.svg" alt="Tested By"></a>
```
