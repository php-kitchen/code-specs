# Directory expectations

In the following example we check that given directory exists and is readable.

```php
public function testDirectory() {
        $tester = $this->tester;
        $tester->checksScenario('working wih directories')
            ->expectsThat('given directory is accessible')
            ->directory(__DIR__)
            ->isExist()
            ->isReadable();
}
```