# Value expectations

In the following displayed basic usage of tester library to compare two values an verify given value match all of the expectations.

```php
public function testValueOf() {
        $tester = $this->tester;
        $tester->checksScenario('Example of basic usage')
            ->expectsThat('everything works')
            ->valueOf(10)
            ->isNotEmpty()
            ->isNotNull()
            ->isTheSameAs(10)
            ->isNotTheSameAs(15);
}
```