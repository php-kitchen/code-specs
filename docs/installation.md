# Installation

## Requirements

**`PHP >= 7.1` is required.**

**`PHPUnit >= 6.0` is required.**

## Getting Started

Run the following command to add PHPUnit Tester to your project's `composer.json`. See [Packagist](https://packagist.org/packages/dekeysoft/pu-tester) for specific versions.

```bash
composer require dekeysoft/pu-tester
```

Or you can copy this library from:
- [Packagist](https://packagist.org/packages/dekeysoft/pu-tester)
- [Github](https://github.com/dekeysoft/pu-tester)

Then you can use PHPUnit Tester in your test simply extending from `Specification` class. Example:
```php
use DeKey\Tester\Specification\Specification;

class YourTest extends Specification {

    public function testSomeMethod() {
        $I = $this->tester;
        ......
        $I->seeThatBoolean('my dummy variable', true)->isFalse();
    }
}

```

or by using "TesterInitialization" trait in your test case

```php
use PHPUnit\Framework\TestCase;
use DeKey\Tester\TesterInitialization;

class YourTest extends TestCase {
    use TesterInitialization;

    public function testSomeMethod() {
        $I = $this->tester;
        ......
        $I->seeThatBoolean('my dummy variable', true)->isFalse();
    }
}
```