# File expectations

In the following example we check that given file exists, is readable and equal to expected file(for example to itself).

```php
public function testFile() {
        $tester = $this->tester;
        $tester->checksScenario('working wih files')
            ->expectsThat('given file is accessible')
            ->file(__FILE__)
            ->isExist()
            ->isReadable()
            ->isEqualTo(__FILE__);
    }
```