# Installation

## Requirements

**`PHP >= 5.6.0` is required.**

**`PHPUnit >= 5.6.0` is required.**

## Installation

To install this library in your project run following command in the terminal:

```bash
composer require dekeysoft/pu-tester
```

Or you can copy this library from:
- [Packagist](https://packagist.org/packages/dekeysoft/pu-tester)
- [Github](https://github.com/dekeysoft/pu-tester)

Then you can use PHPUnit Tester simply by using "TesterInitialization" trait in your test case. Example:
```php
use PHPUnit\Framework\TestCase;
use DeKey\Tester\TesterInitialization;

class YourTestCase extends TestCase {
    use TesterInitialization;

    public function testSomeMethod() {
        $tester = $this->tester;
        ......
    }
}
```

"TesterInitialization" trait inject your test case with "tester" property being initiated before each test so you'll have clean Tester for each of your tests.
It's better to use "TesterInitialization" in your base test case sou you'll have Tester in all of your tests without explicit usage of "TesterInitialization" trait( if you don't have base test it's time to create one=) ). 
