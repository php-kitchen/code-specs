# Installation

## Requirements

**`PHP >= 7.1` is required.**

**`PHPUnit >= 6.0` is required.**

## Getting Started

Run the following command to add PHPUnit Tester to your project's `composer.json`. See [Packagist](https://packagist.org/packages/php-kitchen/code-specs) for specific versions.

```bash
composer require php-kitchen/code-specs
```

Or you can copy this library from:
- [Packagist](https://packagist.org/packages/php-kitchen/code-specs)
- [Github](https://github.com/php-kitchen/code-specs)

Then you can use PHPUnit Tester in your test simply extending from `Specification` class. Example:
```php
use PHPKitchen\CodeSpecs\Specification\Specification;

class YourTest extends Specification {

    public function testSomeMethod() {
        $I = $this->tester;
        ......
        $I->seeBoolean('my dummy variable', true)->isFalse();
    }
}

```

or by using "TesterInitialization" trait in your test case

```php
use PHPUnit\Framework\TestCase;
use PHPKitchen\CodeSpecs\TesterInitialization;

class YourTest extends TestCase {
    use TesterInitialization;

    public function testSomeMethod() {
        $I = $this->tester;
        ......
        $I->seeBoolean('my dummy variable', true)->isFalse();
    }
}
```